<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

use App\Mail\SendMailable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Client;
use App\Company;
use App\Order;
use App\CompanyInformation;
use App\SageTransaction;
use App\Product;
use App\InvoiceMaster;
use App\VirtualAccount;
use App\ScanAccount;
use App\VirtualScanAccount;
use App\ChangeLog;
use App\Setting;
use App\OrderRenewal;
use App\EmailTemplate;
use App\Coupon;
use App\ProductCategory;

use App\User;
use Omnipay\Omnipay;

use DB;
use Auth;
use PDF;
use DOMPDF;
use Cookie;

use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

use App\Http\Traits\HttpResponses;

class ClientController extends Controller
{
    //use HttpResponses;

    public function login(Request $request) {

        $email = $request->get('email');
        $password = $request->get('password');

        //Log::debug('email:' . $email);
        //Log::debug('password:' . $password);

        $loginData = ['email' => $email, 'password' => $password, 'active' => 1, 'deleted' => 0];

        if (Auth::attempt( $loginData )) {

            //$client_id = Auth::guard('client')->user()->id;

            //$client = Client::find( $client_id );

            $client = Auth::user();

            $accessToken = $client->createToken('capital-office')->plainTextToken;  

            //$cookie = cookie('capital-office', $accessToken, 60 * 24 * 365);

            //$client->access_token = $accessToken;

            //$client->save();

            $orders = DB::table('orders')
                        ->select('orders.*', 
                                    DB::raw('companies.name as company_name'), 
                                    
                                    DB::raw('clients.first_name as client_first_name'),
                                    DB::raw('clients.last_name as client_last_name'),
                                    DB::raw('new_users.first_name as user_first_name'),
                                    DB::raw('new_users.last_name as user_last_name'),

                                    DB::raw('CONCAT(directors.first_name, " ", directors.last_name) as officer_name'),
                                    
                                    DB::raw('products_v2.type as product_type'),
                                    DB::raw('products_v2.category as product_category'),
                                    DB::raw('products_v2.name as pname'),
                                    DB::raw('products_v2.name as product_name'),
                                    DB::raw('products_v2.term as product_term'),
                                    DB::raw('products_v2.v2 as product_v2'),
                                    DB::raw('products_v2.type as product_type'),
                                    DB::raw('products_v2.amount as product_amount'),
                                    DB::raw('products_v2.recurring_type as product_recurring_type'),
                                    DB::raw('products_v2.description as product_description'),
                                    DB::raw('products_v2.available_for_purchase as product_available_for_purchase'),
                                    DB::raw('products_v2.active as product_active'),
                                    DB::raw('products_v2.created as product_created'),
                                    DB::raw('products_v2.modified as product_modified'),
                                    DB::raw('products_v2.amlc_checks_required as product_amlc_checks_required'),
                                    DB::raw('products_v2.manual_activation_required'),
                                    DB::raw('(SELECT COALESCE(payment_status, 0) FROM sagetransactions WHERE order_id = orders.id AND payment_status = 2 ORDER BY id DESC LIMIT 1) AS payment_status')
                                )
                        ->join('companies', 'companies.id', '=', 'orders.company_id')
                        ->join('clients', 'clients.id', '=', 'orders.client_id')
                        ->join('products_v2', 'products_v2.id', '=', 'orders.product_id')
                        ->leftJoin('new_users', 'new_users.id', '=', 'orders.user_id')
                        ->leftJoin('directors', 'directors.id', '=', 'orders.officer_id')
                        ->leftJoin('sagetransactions', 'sagetransactions.order_id', '=', 'orders.id')
                        ->whereRaw('orders.deleted = 0')
                        ->whereRaw('orders.contract_enddate > now()')
                        ->whereRaw('orders.expired_status = 0')
                        ->whereRaw('companies.deleted = 0')
                        ->whereRaw('orders.client_id = ' . $client->id)
                        ->orderBy('orders.contract_enddate', 'desc')
                        ->orderBy('orders.id', 'desc')
                        ->get();

            $services = [];

            foreach($orders as $o) {

                if ($o->product_type === 3) {

                    $_included = Product::select(
                                        'products_v2.*', 
                                        'product_extras.product_id', 
                                        'product_extras.extra_product_id'
                                    )
                                    ->join('product_extras', 'product_extras.extra_product_id', '=', 'products_v2.id')
                                    ->where('product_extras.included', '=', 1)
                                    ->whereRaw('products_v2.available_for_purchase = 1')
                                    ->where('product_extras.product_id', '=', $o->product_id)
                                    ->get();

                    

                    if ($_included->count() > 0) {

                        foreach($_included as $i) {

                            if ( $i->recurring_type === 1 ) {

                                $s = (object)[];

                                $s->product_name = $i->name;
                                //$s->product = $i->product;
                                $s->product_term = $o->product_term;
                                $s->company_name = $o->company_name;
                                $s->contract_enddate = $o->contract_enddate;
                                $s->contract_startdate = $o->contract_startdate;
                                $s->order_date = $o->order_date;
                                //$s->sagetransactions = $o->sagetransactions;
                                //$s->transactions = $o->transactions;
                                $s->order_status  = $o->order_status;
                                $s->expired_status = $o->expired_status;
                                $s->id = $o->id;
                                $s->package_order_id = $o->package_order_id;
                                $s->amount = $o->amount;
                                $s->payment_status = $o->payment_status;

                                $services[] = $s;

                            }

                        }                       

                    } else {

                        $s = (object)[];

                        $s->product_name = $o->pname;
                        //$s->product = $o->product;
                        $s->product_term = $o->product_term;
                        $s->company_name = $o->company_name;
                        $s->contract_enddate = $o->contract_enddate;
                        $s->contract_startdate = $o->contract_startdate;
                        $s->order_date = $o->order_date;
                        //$s->sagetransactions = $o->sagetransactions;
                        //$s->transactions = $o->transactions;
                        $s->order_status  = $o->order_status;
                        $s->expired_status = $o->expired_status;
                        $s->id = $o->id;
                        $s->package_order_id = $o->package_order_id;
                        $s->amount = $o->amount;
                        $s->payment_status = $o->payment_status;

                        $services[] = $s;

                    } 

                } else if (($o->product_recurring_type === 1 || $o->product_term > 0 ) && ($o->product_type === 0 || $o->product_type === 2)) {

                    $s = (object)[];

                    $s->product_name = $o->pname;
                    //$s->product = $o->product;
                    $s->product_term = $o->product_term;
                    $s->company_name = $o->company_name;
                    $s->contract_enddate = $o->contract_enddate;
                    $s->contract_startdate = $o->contract_startdate;
                    $s->order_date = $o->order_date;
                    //$s->sagetransactions = $o->sagetransactions;
                    //$s->transactions = $o->transactions;
                    $s->order_status  = $o->order_status;
                    $s->expired_status = $o->expired_status;
                    $s->id = $o->id;
                    $s->package_order_id = $o->package_order_id;
                    $s->amount = $o->amount;
                    $s->payment_status = $o->payment_status;

                    $services[] = $s;

                } else if ($o->product_v2 === 0 && ( $o->product_type === 0 || $o->product_type === 2 ) ) {

                    $s = (object)[];

                    $s->product_name = $o->pname;

                    $s->product_term = $o->product_term;
                    $s->package_order_id = $o->package_order_id;
                    
                    //s.product = o.product;
                    //s.company = o.company;
                    
                    $sagetransactions = [];
                    $transactions = [];
                    
                    $s->contract_enddate = $o->contract_enddate;
                    $s->contract_startdate = $o->contract_startdate;
                    $s->order_date = $o->order_date;
                    $s->sagetransactions = $sagetransactions;
                    $s->transactions = $transactions;
                    $s->order_status  = $o->order_status;
                    $s->expired_status = $o->expired_status;
                    $s->id = $o->id;
                    $s->amount = $o->amount;
                    $s->payment_status = $o->payment_status;

                    $services[] = $s;

                }
            } 

            $data['services'] = $services;
            $data['error'] = 0;
            $data['client'] = $client; 
            $data['accessToken'] = $accessToken;
            

        } else {

            $data['client'] = [];
            $data['error'] = 1;

        }

        

        return response()->json( $data );

    }
}
