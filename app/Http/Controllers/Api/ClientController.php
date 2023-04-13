<?php

namespace App\Http\Controllers\Api;

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
    public function login( Request $request ) {

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

    public function accounts(Request $request) {

        $client = Auth::user();

        $accounts = Company::select(DB::raw('companies.id'), 
                                        'name', 
                                        't_mailbox_number', 
                                        DB::raw('companies.phone_number'),
                                        'telephone_number',
                                        'voicemail_number',
                                        'frequency',
                                        'email',
                                        'website',
                                        'city',
                                        'post_code',
                                        'known_as',
                                        'quickbookid',
                                        'address_1',
                                        'forwarding_email',
                                        'answer_1',
                                        'answer_2',
                                        'answer_3',
                                        'answer_4',
                                        'answer_5'
                                        )
                        ->where('client_id', '=', $client->id)
                        ->where('deleted', '=', 0)
                        ->leftJoin('company_informations', 'company_id', '=', 'companies.id')
                        ->get();

        foreach( $accounts as $a ) {

            $a->documents;
            $a->emails;
            $a->directors;

            $orders = Order::select('orders.id', 
                                 DB::raw('IF(c.amlc_status = 1, 1, orders.amlc) as amlc'),
                                 'orders.client_id',
                                 'orders.company_id',
                                 'orders.order_date',
                                 'orders.contract_startdate',
                                 'orders.contract_enddate',
                                 DB::raw('c.name as company_name'), 
                                 DB::raw('p.name as product_name'), 
                                 DB::raw('p.manual_activation_required'),
                                 DB::raw('CONCAT(c2.last_name, ", ", c2.first_name) as client_name'),
                                 DB::raw('c2.industry as client_industry'),
                                 DB::raw('c.amlc_status')
                            )
                        ->join('sagetransactions', 'sagetransactions.order_id', '=', 'orders.id')
                        ->join('companies as c', 'c.id', '=', 'orders.company_id')
                        ->join('clients as c2', 'c2.id', '=', 'orders.client_id')
                        ->join('products_v2 as p', 'p.id', '=', 'orders.product_id')
                        ->orderBy('orders.created', 'desc')
                        ->whereRaw("product_id IN (SELECT id FROM products_v2 WHERE amlc_checks_required = 1 and manual_activation_required = 0)")
                        ->where('package_order_id', '=', 0)
                        ->where('sagetransactions.payment_status', '=', 2)
                        ->where('orders.type', '=', 0)
                        ->where('orders.deleted', '=', 0)
                        ->where('company_id', '=', $a->id)
                        ->get();

           

            foreach($orders as $o) {

                $o->amlc_notes;                

            }

            $amlq = [
                        'action_needed' => $orders->filter(function($row, $key) {
                                                return $row->amlc == 0 && $row->manual_activation_required == 0;
                                            }),
                        'invited' => $orders->filter(function($row, $key) {
                                            return $row->amlc == 2;
                                        }),
                        'requested' => $orders->filter(function($row, $key) {
                                            return $row->amlc == 3;
                                        }),
                        'passed' => $orders->filter(function($row, $key) {
                                        return $row->amlc == 1;
                                    }),
                        'cancelled' => $orders->filter(function($row, $key) {
                                            return $row->amlc == 4;
                                        }),
                        'manual_activation' => $orders->filter(function($row, $key) {
                                            return $row->amlc == 0 && $row->manual_activation_required == 1;
                                        }),
                        'failed' => [],
                    ];

            $a->amlq = $amlq;

        }

        $client->accounts = $accounts;

        $client->company_types = [
            1 => 'Limited Company',
            2 => 'Partnership',
            3 => 'Charity',
            4 => 'Limited by Guarantee',
            5 => 'Sole Trader'
        ];

        $data['client'] = $client;

        return response()->json( $data );

    }

    public function services() {

        $client = Auth::user();

        $client_id = Auth::user()->id;

        //$client_id = $client->id;

        $included = Product::select('products_v2.*', 'product_extras.product_id', 'product_extras.extra_product_id')
                                    ->join('product_extras', 'product_extras.extra_product_id', '=', 'products_v2.id')
                                    ->where('product_extras.included', '=', 1)
                                    ->whereRaw('products_v2.available_for_purchase = 1')
                                    ->get();

        $services = [];

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
                        ->whereRaw('companies.deleted = 0')
                        ->whereRaw('orders.client_id = ' . $client_id)
                        ->orderBy('orders.contract_enddate', 'desc')
                        ->orderBy('orders.id', 'desc');
        
        $posts = $orders;

        $orders = $orders->get(); 

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


        $transactions = DB::table('transactions')
                                ->select('transactions.*')
                                ->whereRaw('order_id IN (SELECT id FROM orders WHERE client_id = '. $client_id .')')
                                ->get();

        $client->transactions = $transactions; 

        $client->orders = $orders;

        $client->service_posts =  $posts->where('orders.type', '=', 1)->get();

        $client->post_logs;

        $client->sagetransactions;

        $client->services = $services;

        $client->included = $included;

        $data['client'] = $client;

        return response()->json( $data );

    }


    public function postHistory() {

        $client = Auth::user();

        $client->post_logs;

        $client->orders;

        $data['client'] = $client;

        return response()->json( $data );

    }

    public function payInvoice() {

        $client = Auth::user();

        $client_id = $client->id;

        foreach($client->invoices as $i) {

            $i->payNow = sprintf("%s/app/invoice/%s/pay-now", env('APP_URL'), $i->invoice_id);

        }

        $data['client'] = $client;

        return response()->json( $data );

    }

    public function postageFunds() {

        $client = Auth::user();

        $client_id = $client->id;

        $client->companies;

        $funds = $client->virtual_accounts;

        $scan_accounts = [];

        $earnings = 0;
        $totalFunds = 0;
        $credits = 0;
        $debits = 0;

        $scan_debits = 0;
        $scan_credits = 0;

        $accounts = [];

        foreach($client->affiliates as $a) {

            $earnings += $a->commission;

        }

        foreach($client->virtual_scan_accounts as $v) {

            if ($v->paid_via_commission) {

                $earnings -= $v->total_amount;

            }

        }

        foreach($client->virtual_accounts as $a) {

            if ($a->paid_via_commission) {

                $earnings -= $a->total_amount;

            }

            if ($a->payment_status == 2) {

                $credits += $a->credit_amount;
                $debits += $a->debit_amount;

                $accounts[] = ['debit_amount' => $a->debit_amount, 'credit_amount' => $a->credit_amount, 'created' => $a->created];

            }

        }

        foreach($client->scan_accounts as $s) {

            if ($s->payment_status == 2) {

                $scan_credits += $s->credit_quantity;
                $scan_debits += $s->debit_quantity;

                $scan_accounts[] = $s;
                
            }

        }

        foreach($client->post_logs as $p) {

            if ($p->postage_charge == 1) {

                $debits += $p->postage_amount;

                $accounts[] = ['debit_amount' => $p->postage_amount, 'credit_amount' => 0, 'created' => $p->created_at];

            }

            if ($p->scan_charge == 1) {

                $scan_debits += $p->scan_quantity;

            }

        }

        

        $orders = $client->orders;

        $client->funds = $funds;

        $client->scan_accounts = $scan_accounts;

        $client->earnings = $earnings;

        $client->total_fund = $credits - $debits;
        $client->total_scan = $scan_credits - $scan_debits;

        $data['client'] = $client;
        $data['scan_bundles'] = [
                           [
                            'name' => '10 scans - £10',
                            'amount' => 10
                           ],
                           [
                            'name' => '20 scans - £14',
                            'amount' => 20
                           ],
                           [
                            'name' => '40 scans - £20',
                            'amount' => 40
                           ],
                           [
                            'name' => '100 scans - £40',
                            'amount' => 100
                           ],
                        ];

        return response()->json( $data );

    }

    public function paymentHistory( ) {

        $client  = Auth::user();

        $client_id = $client->id;

        $orders = Order::select(
                            DB::raw('orders.product_name'),
                            DB::raw('orders.contract_enddate as expiry_date'),
                            DB::raw('orders.amount'),
                            DB::raw('(orders.amount * 0.2) as vat_amount'),
                            DB::raw('orders.total_amount as total'),
                            DB::raw('companies.name as company_name'),
                            'total_discount_amount'
                        )
                    ->join('companies', 'companies.id', '=', 'orders.company_id')
                    ->where(DB::raw('orders.client_id'), '=', $client_id)
                    ->where('package_order_id', '=', 0)                    
                    ->get();

        $funds = VirtualAccount::select(
                            'virtual_accounts.*',
                            DB::raw('"Payment Top Up" as `order`'),
                            DB::raw('IF(type = 0, "Debit", "Credit") as `type`'),
                            DB::raw('(SELECT transaction_id FROM sagetransactions WHERE virtual_account_id = virtual_accounts.id AND payment_status = 2 LIMIT 1) as transaction_id')
                        )
                    ->where('client_id', '=', $client_id)
                    ->where('payment_status', '=', 2)
                    ->get();

        $scans = ScanAccount::select(
                                DB::raw('"Scan Top Up" as `order`'),
                                DB::raw('IF(`type` = 0, "Debit", "Credit") AS `type`'),
                                DB::raw('debit_quantity'),
                                DB::raw('credit_quantity'),
                                DB::raw('NULL as transaction_id'),
                                'payment_status',
                                'created'
                            )
                        ->where('client_id', '=', $client_id)                      
                        ->where('payment_status', '=', 2)
                        ->get();

        

        $client->orders = $orders;

        $client->funds = $funds;

        $client->scans = $scans;

        $data['client'] = $client;

        return response()->json( $data );

    }

    public function affiliates() {

        $client = Auth::user();

        $client_id = $client->id;

        $affiliates = $client->affiliates;

        $virtualAccounts = VirtualAccount::where('client_id', '=', $client_id)
                                ->where('paid_via_commission', '=', 1)
                                ->get();

        $scanAccounts = VirtualScanAccount::where('client_id', '=', $client_id)
                            ->where('paid_via_commission', '=', 1)
                            ->get();

        $products = Product::select(
                                'id',
                                'amount',
                                'name',
                                'term'
                            )
                        ->where('type', '=', 3)
                        ->get();

        foreach($products as $p) {

            switch ($p->term) {

                case 1: $term = '1 Month';

                break;

                case 3: $term = '1 Months'; break;

                case 6: $term = '6 Months'; break;

                case 12: $term = '1 Year'; break;

                default: 

                    $term = '';


            }

            $p->url = env('APP_URL') . '/affiliates/' . $p->id . '/' . $client_id;
            $p->commission = $client->commission * $p->amount / 100;
            $p->product_name = sprintf("%s %s", $p->name, $term);

        }

        $earnings = 0;
        $spend = 0;

        foreach($affiliates as $a) {
            $earnings += $a->commission;
        }

        foreach($virtualAccounts as $v) {

            $spend += $v->total_amount;

        }

        foreach($scanAccounts as $s) {

            $spend += $s->total_amount;

        }

        $client->earnings = $earnings;
        $client->balance = $earnings - $spend;
        $client->products = $products;

        $data['client'] = $client;

        return response()->json( $data );

    }

    public function notifications() {

        $client = Auth::user();

        if ($client) {

            $client_id = $client->id;

            $emails = DB::table('email_queues')
                                ->select('email_queues.*', 'companies.name as company_name')
                                ->join('companies', 'companies.id', '=', 'email_queues.company_id')
                                ->whereRaw('(company_id IN (SELECT id FROM companies WHERE companies.deleted = 0 AND client_id = '. $client->id .') OR to_email = "'. $client->email .'")')
                                ->where('show_to_client', '=', 1)
                                ->orderBy(DB::raw('email_queues.created'), 'desc')
                                ->get();   

            $client->notifications = $emails;

            $data['client'] = $client;

            return response()->json( $data );

        } else {

            return response()->json( ['error' => 1] );

        }

    }

    public function saveProfile( Request $request ) {

        $client = Auth::user();

        $current = $client->toArray();

        $client->first_name = $request->get('first_name');
        $client->last_name = $request->get('last_name');
        $client->phone_number = (string)$request->get('phone_number');
        $client->date_of_birth = $request->get('date_of_birth');
        
        $client->address = $request->get('address');
        $client->city = $request->get('city');
        $client->post_code = $request->get('post_code');

        $client->country = $request->get('country');

        $client->save();

        $client->dob = Carbon::parse( $client->date_of_birth )->format("d/m/Y");

        $results = array_diff_assoc($current, $client->toArray());

        unset($results['modified']);

        if ($results) {

            $user = $client; //Client::find(auth()->id());

            foreach ($results as $field => $result) {

                $change_log = new Changelog;

                $oldValue = $result;
                $newValue = $client[$field];
                $oldValue = !empty($oldValue) ? $oldValue : '-';
                $newValue = !empty($newValue) ? $newValue : '-';
                
                $change_log['table_id'] = $client->id;
                $change_log['table_name'] = 'Clients';
                $change_log['field'] = $field;

                $change_log['description'] =  sprintf("Client (%s %s) has updated the the client field  %s  value from %s to %s", $user->first_name, $user->last_name, $field, $oldValue, $newValue);

                $change_log['old_value'] = $oldValue;
                $change_log['new_value'] = $newValue;
                
                $change_log['modified_user_id'] = $client->id;
                $change_log['modified_client_id'] = $client->id;

                $change_log->save();
            }
        }

        return response()->json(['client' => $client, 'x' => 'x'], 200, [], JSON_NUMERIC_CHECK);

    }

    public function addNewService() {

        $client = Auth::user();

        $client_id = $client->id;

        $companies = Company::select(
                                'id',
                                'name'
                            )
                        ->where('client_id', '=', $client_id)
                        ->where('deleted', '=', 0)
                        ->get();

        $packages = Product::select('name', 'amount', 'term', 'id')
                        ->where('available_for_purchase', '=', 1)
                        ->where('type', '=', 3)
                        ->get();

        $categories = ProductCategory::where('package', '=', 1)->get();

        foreach($packages as $p) {

            $p->included;
            
            $p->free_optionals;

            $optionals = DB::table('product_extras')
                            ->select('product_extras.*','p2.name','p2.category', DB::raw('product_categories.name as category_name'))
                            ->where('product_extras.optional', '=', 0)
                            ->where('product_extras.included', '=', 0)
                            ->where('product_extras.price', '>', 0)
                            ->join(DB::raw('products_v2 p2'), 'p2.id','=','product_extras.extra_product_id')
                            ->join('product_categories', 'product_categories.id','=', 'p2.category')
                            ->orderBy(DB::Raw('CONCAT(p2.name, " ", p2.term)'), 'asc')
                            ->where('product_extras.product_id', '=', $p->id)
                            ->get();

            $p->_optionals = $optionals->groupBy('category_name')->all();

        }

        $products = DB::table('products_v2')
                        ->select(
                            DB::raw('products_v2.id'),
                            DB::raw('products_v2.name'), 
                            'amount', 
                            'term', 
                            DB::raw('product_categories.name as category_name')
                        )
                        ->join('product_categories', 'product_categories.id', '=', 'category')
                        ->where('available_for_purchase', '=', 1)
                        ->where('package', '=', 1)
                        ->where('amount', '>', 0)
                        ->whereIn('type', [0, 2])
                        ->get();

        $data['packages'] = $packages;
        $data['products'] = $products->groupBy('category_name');
        $data['client'] = $client;
        $data['companies'] = $companies;
        $data['categories'] = $categories;

        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);

    }


    public function renew($id) {

        $products = Product::select(
                                'name',
                                'amount',
                                'description',
                                'term'
                            )
                        ->where('deleted','=',0)
                        ->whereIn('type',[0, 2, 3])
                        ->where('available_for_purchase', '=', 1)
                        ->get();

        $categories = ProductCategory::where('deleted','=', 0)->where('package','=', 1)->get();

        $order = Order::find($id);

        $package = Order::select(
                            DB::raw('orders.id as order_id'),
                            'contract_startdate',
                            'contract_enddate',
                            'order_date',
                            'product_id',
                            'mail_option',
                            'forwarding_address_fee',
                            DB::raw('orders.company_id'),
                            DB::raw('orders.client_id'),
                            DB::raw('clients.first_name'),
                            DB::raw('clients.last_name'),
                            DB::raw('companies.name as company_name'),
                            DB::raw('clients.address'),
                            DB::raw('clients.city'),
                            DB::raw('clients.post_code'),
                            DB::raw('clients.country'),
                            DB::raw('clients.email'),
                            DB::raw('clients.phone_number'),
                            DB::raw('products_v2.description'),
                            DB::raw('products_v2.amount as amount'),
                            DB::raw('products_v2.name as product_name'),
                            DB::raw('products_v2.term')                            
                        )
                    ->join('products_v2', 'products_v2.id', '=', 'product_id')
                    ->join('clients', 'clients.id', '=', 'orders.client_id')
                    ->join('companies', 'companies.id', '=', 'orders.company_id')
                    ->where('orders.id', '=', $id)
                    ->first();

        $scans = VirtualScanAccount::select(
                                'credit_amount',
                                'credit_quantity',
                                'debit_amount',
                                'debit_quantity'
                            )
                        ->where('order_id', '=', $id)
                        ->get();

        $package->scans = $scans;

        $included = Order::select(
                            DB::raw('orders.id'),
                            'contract_startdate',
                            'contract_enddate',
                            'order_date',
                            'product_id',
                            'mail_option', 
                            'code_selected',
                            'code_203_cost',
                            'code_207_cost',  
                            'forward_calls',   
                            'forwarding_deposit',
                            DB::raw('(SELECT price FROM product_extras WHERE product_id = ' . $package->product_id . ' AND extra_product_id = orders.product_id AND ( price > 0 OR included = 1) LIMIT 1) as override_price'),
                            DB::raw('products_v2.description'),
                            DB::raw('products_v2.amount as amount'),
                            DB::raw('products_v2.name as product_name'),
                            DB::raw('products_v2.term')
                        )
                    ->join('products_v2', 'products_v2.id', '=', 'product_id')
                    ->where('package_order_id', '=', $id)
                    ->where('orders.deleted', '=', 0)
                    ->get();


        
        

        $client = [
                'first_name' => $order->client->first_name,
                'last_name' => $order->client->last_name,
                'email' => $order->client->email,
                'phone_number' => $order->client->phone_number,
                'business_name' => $order->client->business_name,
                'address' => $order->client->address,
                'city' => $order->client->city,
                'post_code' => $order->client->post_code,
                'country' => $order->client->country
            ];

        foreach($order->client->companies as $c) {

            $companies[] = [
                                'id' => $c->id,
                                'name' => $c->name
                            ];

        }
        
        $data['client'] = $client;
        $data['companies'] = $companies;        
        $data['package'] = $package;
        $data['included'] = $included;
        //$data['products'] = $products;
        //$data['categories'] = $categories;

        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);



    }

    public function invoicePayNow( $id ) {

        $invoice = InvoiceMaster::where('invoice_id', '=', $id)->first();

        $client = $invoice->client;

        $invoice->id = $invoice->invoice_id;
        $invoice->product_name = sprintf("INVOICE #%s", $invoice->invoice_id);
        $invoice->total_amount = $invoice->gross_amount;

        list($method, $url, $items) = $this->invoice_sage_processing($client, $invoice);

        $data['method'] = $method;
        $data['url'] = $url;
        $data['items'] = $items;

        return view('sagepay.form', $data);

    }

    public function invoice_sage_processing($client, $order) {

        $gateway = OmniPay::create('SagePay\Form')->initialize([
            'vendor' => env('SAGEPAY_VENDOR'),
            'testMode' => env('SAGEPAY_TESTMODE'),
            'encryptionKey' => env('SAGEPAY_KEY')
        ]);

        $successUrl = url('/api/invoice/'.$order->id.'/success');
        $failedUrl = url('/api/invoice/'.$order->id.'/failed');

        //echo $order->total_amount;

        $params = [
            'Description' => $order->product_name,

            'card' => [
                'billingFirstName' => $client->first_name,
                'billingLastName' => $client->last_name,
                'billingAddress1' => !empty($client->address) ? $client->address : 'Address',
                'billingCity' => !empty($client->city) ? $client->city : 'London' ,
                'billingPostcode' => !empty($client->post_code) ? $client->post_code : 'HP27DX',
                'billingCountry' => 'GB',
                'billingState' => 'London',
                'billingPhone' => $client->phone_number
            ],

            'transactionId' => sprintf('INVOICE-%s-%s', $order->id, rand()),
            
            'amount' => number_format($order->total_amount, 2, '.', ''),
            'currency' => 'GBP',
            
            'billingForShipping' => true,

            'shippingFirstName' => $client->first_name,
            'shippingLastName' => $client->last_name,
            'shippingAddress1' => !empty($client->address) ? $client->address : 'Address',
            'shippingCity' => !empty($client->city) ? $client->city : 'London' ,
            'shippingPostcode' => !empty($client->post_code) ? $client->post_code : 'HP27DX',
            'shippingCountry' => 'GB',

            'returnUrl' => $successUrl,
            'failureUrl' => $failedUrl,
        ];       

        $response = $gateway->purchase($params)->send();

        //print_r($params); die();

        $method = $response->getRedirectMethod();
        
        $url = $response->getRedirectUrl();
        
        $hiddenFormItems = $response->getRedirectData();   
       
        return [$method, $url, $hiddenFormItems];

    }

    public function payNow(Request $request) {
        
        $account = new VirtualAccount;

        $setting = Setting::where('name','=','common_vat_percentage')->first();

        $vat = $setting->value;

        $amount = $request->get('amount');

        $total_amount = $amount + ($amount * $vat / 100);

        $client = Client::find($request->get('client_id'));

        $account->client_id = $request->get('client_id');
        $account->credit_amount = $amount;
        $account->type = 1;
        $account->vat = $vat;
        $account->total_amount = $total_amount;
        $account->payment_status = 1;
       
        $account->save();

        $payment_id = $account->id;

        $gateway = OmniPay::create('SagePay\Form')->initialize([
            'vendor' => env('SAGEPAY_VENDOR'),
            'testMode' => env('SAGEPAY_TESTMODE'),
            'encryptionKey' => env('SAGEPAY_KEY')
        ]);
        
        $successUrl = url('/api/topup/'.$payment_id.'/success');
        $failedUrl = url('/api/topup/'.$payment_id.'/failed');

        $params = [
            'Description' => 'Payment Top up',

            'card' => [
                'billingFirstName' => $client->first_name,
                'billingLastName' => $client->last_name,
                'billingAddress1' => !empty($client->address) ? $client->address : 'Address',
                'billingCity' => !empty($client->city) ? $client->city : 'London' ,
                'billingPostcode' => !empty($client->post_code) ? $client->post_code : 'EC1V 2NX',
                'billingCountry' => 'GB',
            ],

            'transactionId' => sprintf('TOPUP-%s-%s', $payment_id, rand()),
            
            'amount' => round($total_amount, 2),
            'currency' => 'GBP',
            
            'billingForShipping' => true,

            'shippingFirstName' => $client->first_name,
            'shippingLastName' => $client->last_name,
            'shippingAddress1' => !empty($client->address) ? $client->address : 'Address',
            'shippingCity' => !empty($client->city) ? $client->city : 'London' ,
            'shippingPostcode' => !empty($client->post_code) ? $client->post_code : 'HP27DX',
            'shippingCountry' => 'GB',

            'returnUrl' => $successUrl,
            'failureUrl' => $failedUrl,
        ];

       

        $response = $gateway->purchase($params)->send();

        $method = $response->getRedirectMethod();
        $url = $response->getRedirectUrl();
        $hiddenFormItems = $response->getRedirectData();        

        //$request->session()->put('sagepay-method', $method);
        //$request->session()->put('sagepay-url', $url);
        //$request->session()->put('sagepay-items', $hiddenFormItems);

        $data['success'] = 1;
        $data['code'] = $payment_id;      
        
        $data['method'] = $method;
        $data['url'] = $url;
        $data['items'] = $hiddenFormItems;

        return view('sagepay.form', $data);

    }

    public function payViaCommission( Request $request ) {

        $account = new VirtualAccount;

        $setting = Setting::where('name','=','common_vat_percentage')->first();

        $vat = $setting->value;

        $amount = $request->get('amount');

        $total_amount = $amount + ($amount * $vat / 100);

        $client = Client::find($request->get('client_id'));

        $earning = 0;

        foreach( $client->affiliates as $f ) {

            $earning += $f->commission;

        }

        foreach( $client->virtual_accounts as $a ) {

            if ( $a->paid_via_commission == 1 ) {

                $earning -= $a->total_amount;

            }

        }

        foreach( $client->virtual_scan_accounts as $a ) {

            if ( $a->paid_via_commission == 1 ) {

                $earning -= $a->total_amount;

            }

        }

        $payment_status = $earning >= $total_amount ? 2 : 1;

        if ( $payment_status == 2 ) {

            $account->client_id = $request->get('client_id');
            $account->credit_amount = $amount;
            $account->type = 1;
            $account->vat = $vat;
            $account->paid_via_commission = 1;        
            $account->total_amount = $total_amount;
            $account->payment_status = 1;
        
            $account->save();

            return $this->topUpSuccess( $account->id, false );

        } else {

            return response()->json( ['success' => 0], 200, [], JSON_NUMERIC_CHECK );

        }

    }

    public function saveScanViaCommission(Request $request) {

        $setting = Setting::where('name', '=', 'common_vat_percentage')->first();

        $scan = new ScanAccount;

        $virtual = new VirtualScanAccount;

        $client_id = $request->get('client_id');

        $company_id = $request->get('company_id');

        $company = Company::find( $company_id );

        $credit_quantity = $request->get('scan');

        $vat = $setting->value;

        switch ($credit_quantity) {
            case 10: $credit_amount = 10; break;
            case 20: $credit_amount = 14; break;
            case 40: $credit_amount = 20; break;
            case 100: $credit_amount = 40; break;
        }

        $total_amount = $credit_amount + ($credit_amount * $vat / 100);

        $client = Client::find($client_id);

        $earning = 0;

        foreach( $client->affiliates as $f ) {

            $earning += $f->commission;

        }

        foreach( $client->virtual_accounts as $a ) {

            if ( $a->paid_via_commission == 1 ) {

                $earning -= $a->total_amount;

            }

        }

        foreach( $client->virtual_scan_accounts as $a ) {

            if ( $a->paid_via_commission == 1 ) {

                $earning -= $a->total_amount;

            }

        }

        $payment_status = $earning >= $total_amount ? 2 : 1;

        if ( $payment_status == 2 ) {

            $scan->client_id = $client_id;
            $scan->payment_status = $payment_status;
            $scan->type = 1;      
            $scan->credit_quantity = $credit_quantity;
            $scan->company_id = $company_id;        

            $scan->save();

            $virtual->client_id = $client_id;
            $virtual->payment_status = $payment_status;
            $virtual->type = 1;
            $virtual->paid_via_commission = 1;
            $virtual->credit_amount = $credit_amount;
            $virtual->credit_quantity = $credit_quantity;
            $virtual->vat = $vat;
            $virtual->scan_account_id = $scan->id;
            $virtual->total_amount = $total_amount;

            $virtual->save();

            //

            return $this->scanTopUpSuccess( $virtual->id, false );

        } else {

            return response()->json( ['success' => 0], 200, [], JSON_NUMERIC_CHECK );

        }

    }

    public function transferFundsToScans( Request $request ) {

        $client = Client::find( $request->get('client_id') );

        $scan = new ScanAccount;

        $virtual = new VirtualScanAccount;

        $client_id = $request->get('client_id');

        $company_id = $request->get('company_id');

        $company = Company::find( $company_id );

        $credit_quantity = $request->get('scan');

        switch ( $credit_quantity ) {
            case 10: $credit_amount = 10; break;
            case 20: $credit_amount = 14; break;
            case 40: $credit_amount = 20; break;
            case 100: $credit_amount = 40; break;
            default:
                $credit_amount = $credit_quantity;
        }

        $total_amount = $credit_amount;

        $scan->client_id = $client_id;
        $scan->payment_status = 2;
        $scan->type = 1;      
        $scan->credit_quantity = $credit_quantity;
        $scan->company_id = $company_id;        

        $scan->save();

        $virtual->client_id = $client_id;
        $virtual->payment_status = 2;
        $virtual->type = 1;
        $virtual->credit_amount = $credit_amount;
        $virtual->credit_quantity = $credit_quantity;
        $virtual->vat = 0;
        $virtual->scan_account_id = $scan->id;
        $virtual->total_amount = $total_amount;

        $virtual->save();

        $account = new VirtualAccount;

        $vat = 0;

        $amount = -$credit_amount;

        $total_amount = $amount + ($amount * $vat / 100);

        $account->client_id = $client_id;
        $account->credit_amount = $amount;
        $account->type = 1;
        $account->vat = $vat;
        $account->total_amount = $total_amount;
        $account->payment_status = 2;
       
        $account->save();

        $scan_accounts = $client->scan_accounts;
        $virtual_accounts = $client->virtual_accounts;

        $data = ['scan_accounts' => $scan_accounts, 'virtual_accounts' => $virtual_accounts];

        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);

    }

    public function topUpSuccess($id, $redirect = true) {

        $virtual = VirtualAccount::find($id);

        $current = $virtual->toArray();

        $virtual->payment_status = 2;

        $virtual->save();

        $client = Client::find( $virtual->client_id );

        $data['client'] = $client;
        $data['virtual'] = $virtual;

        $email = 'g9q7fi@inbox.groovehq.com';

        $message = view('client.top-up', $data)->render();

        $subject = 'CLIENT TOP UP';

        $mail = new SendMailable($message, $subject);

        $mail->mail = $email;

        $mail->template = $subject;

        $mail->process_name = $subject;

        $mail->show_to_client = 0;

        $mail->company_id = 0;

        $mail->to_name = 'Capital Office';
        $mail->to_email = $email;        

        $this->save_log( $current, $virtual, 'Virtual Account', $client );

        
        return response()->json(['success' => 1], 200, [], JSON_NUMERIC_CHECK);
    }

    public function topUpFailed($id) {
        
        $virtual = VirtualAccount::find($id);

        $virtual->payment_status = 0;

        $virtual->save();

        return view('sagepay.failed');

    }

    public function scanTopUpSuccess( $id, $redirect = true ) {
        
        $virtual = VirtualScanAccount::find($id);

        $current = $virtual->toArray();

        $virtual->payment_status = 2;

        $virtual->save();

        $scan = ScanAccount::find($virtual->scan_account_id);

        $scan->payment_status = 2;

        $scan->save();

        $client = Client::find( $virtual->client_id );

        $data['client'] = $client;
        $data['virtual'] = $virtual;

        $email = 'g9q7fi@inbox.groovehq.com';

        $message = view('client.top-up', $data)->render();

        $subject = 'CLIENT SCAN TOP UP';

        $mail = new SendMailable($message, $subject);

        $mail->mail = $email;

        $mail->template = $subject;

        $mail->process_name = $subject;

        $mail->show_to_client = 0;

        $mail->company_id = 0;

        $mail->to_name = 'Capital Office';
        $mail->to_email = $email;

        
        $this->save_log( $current, $virtual, 'Scan Account', $client);

        

        return response()->json(['success' => 1], 200, [], JSON_NUMERIC_CHECK);
    }

    public function scanTopUpFailed($id) {
        
        $virtual = VirtualScanAccount::find($id);

        $virtual->payment_status = 0;

        $virtual->save();

        $scan = ScanAccount::find($virtual->scan_account_id);

        $scan->payment_status = 0;

        $scan->save();

        return view('sagepay.failed');

    }

    public function saveScan(Request $request) {

        $setting = Setting::where('name', '=', 'common_vat_percentage')->first();

        $scan = new ScanAccount;

        $virtual = new VirtualScanAccount;

        $client_id = $request->get('client_id');

        $company_id = $request->get('company_id');

        $company = Company::find( $company_id );

        $credit_quantity = $request->get('scan');

        $vat = $setting->value;

        switch ($credit_quantity) {
            case 10: $credit_amount = 10; break;
            case 20: $credit_amount = 14; break;
            case 40: $credit_amount = 20; break;
            case 100: $credit_amount = 40; break;
        }

        $total_amount = $credit_amount + ($credit_amount * $vat / 100);

        $scan->client_id = $client_id;
        $scan->payment_status = 1;
        $scan->type = 1;      
        $scan->credit_quantity = $credit_quantity;
        $scan->company_id = $company_id;        

        $scan->save();

        $virtual->client_id = $client_id;
        $virtual->payment_status = 1;
        $virtual->type = 1;
        $virtual->credit_amount = $credit_amount;
        $virtual->credit_quantity = $credit_quantity;
        $virtual->vat = $vat;
        $virtual->scan_account_id = $scan->id;
        $virtual->total_amount = $total_amount;

        $virtual->save();

        $client = Client::find($client_id);

        $gateway = OmniPay::create('SagePay\Form')->initialize([
            'vendor' => env('SAGEPAY_VENDOR'),
            'testMode' => env('SAGEPAY_TESTMODE'),
            'encryptionKey' => env('SAGEPAY_KEY')
        ]);
        
        $successUrl = url('/api/scan-topup/'.$virtual->id.'/success');
        $failedUrl = url('/api/scan-topup/'.$virtual->id.'/failed');

        $params = [
            'Description' => 'Payment Top up',

            'card' => [
                'billingFirstName' => $client->first_name,
                'billingLastName' => $client->last_name,
                'billingAddress1' => !empty($company->address_1) ? $company->address_1 : 'Address',
                'billingCity' => !empty($company->city) ? $company->city : 'London' ,
                'billingPostcode' => !empty($company->post_code) ? $company->post_code : 'HP27DX',
                'billingCountry' => 'GB',
            ],

            'transactionId' => sprintf('SCAN-TOPUP-%s-%s', $virtual->id, rand()),
            
            'amount' => $total_amount,
            'currency' => 'GBP',
            
            'billingForShipping' => true,

            'shippingFirstName' => $client->first_name,
            'shippingLastName' => $client->last_name,
            'shippingAddress1' => !empty($company->address_1) ? $company->address_1 : 'Address',
            'shippingCity' => !empty($company->city) ? $company->city : 'London' ,
            'shippingPostcode' => !empty($company->post_code) ? $company->post_code : 'HP27DX',
            'shippingCountry' => 'GB',

            'returnUrl' => $successUrl,
            'failureUrl' => $failedUrl,
        ];       

        $response = $gateway->purchase($params)->send();

        $method = $response->getRedirectMethod();
        $url = $response->getRedirectUrl();
        $hiddenFormItems = $response->getRedirectData();        

        //$request->session()->put('sagepay-method', $method);
        //$request->session()->put('sagepay-url', $url);
        //$request->session()->put('sagepay-items', $hiddenFormItems);

        $data['success'] = 1;
        $data['code'] = $virtual->id;   
        
        $data['method'] = $method;
        $data['url'] = $url;
        $data['items'] = $hiddenFormItems;

        return view('sagepay.form', $data);
        

    }

    private function save_log( $current, $new, $table, $client ) {

        $results = array_diff_assoc($current, $new->toArray());

        unset($results['modified']);

        if ($results) {

            $user = $client;
 
            foreach ($results as $field => $result) {

                $change_log = new Changelog;

                $oldValue = $result;
                $newValue = $new[$field];
                $oldValue = !empty($oldValue) ? $oldValue : '';
                $newValue = !empty($newValue) ? $newValue : '';
                
                $change_log['table_id'] = $new->id;
                $change_log['table_name'] = $table;
                $change_log['field'] = $field;
                $change_log['description'] =  sprintf("%s %s has updated the %s field  %s  value from %s to %s", $user->first_name, $user->last_name, $table, $field, $oldValue, $newValue);
                $change_log['old_value'] = $oldValue;
                $change_log['new_value'] = $newValue;
                
                $change_log['modified_client_id'] = $user->id;
                $change_log['modified_user_id'] = 0;

                $change_log->save();
            }
        }

    }

    public function getCoupon(Request $request) {

        if ($request->has('coupon')) {

            $order_id = 0;

            $valid = true;

            if ($request->has('order_id')) {

                $order_id = $request->get('order_id');
    
                $order = Order::find( $order_id );
    
            }

            $coupon = Coupon::where('code','=', $request->get('coupon'))
                    ->where('deleted', '=', 0)
                    ->where('active', '=', 1)
                    ->where('valid_from', '<=', Carbon::now())
                    ->where('valid_to', '>=', Carbon::now())
                    ->first();

            if ( $coupon ) {

                if ( $coupon->validity > 0 ) {

                    if ( $order_id > 0 ) {

                        $mail = EmailQueue::where('process_name', '=','ORDER_RENEWAL_28TH_DAY_REMINDER')
                                    ->where('company_id', '=', $order->company_id)
                                    ->where('to_email', '=', $order->client->email)
                                    ->where('created', '<=', Carbon::now()->addDays( $coupon->validity / 24 ))
                                    ->orderBy('created', 'desc')
                                    ->first();

                        if (!$mail) {

                            $valid = false;

                        }
                            

                    } else {

                        $valid = false;

                    }
                } 

                if ( $coupon->days_before > 0 ) {

                    if ( $order_id > 0 ) {

                        $diff = Carbon::parse( $order->contract_enddate )->diffInDays( Carbon::now() );

                        if ( $diff > $coupon->days_before ) {

                            $valid = false;

                        }

                    } else {

                        $valid = false;

                    }

                }

                if ( $valid ) {

                    $data['discount'] = $coupon->discount_percentage;
                    $data['coupon_id'] = $coupon->id;
                    $data['code'] = $coupon->code;

                    return response()->json($data, 200, [], JSON_NUMERIC_CHECK);

                } 

            }            

        }

        return response()->json(['discount' => 0], 200, [], JSON_NUMERIC_CHECK);

    }

    public function payRenew(Request $request) {

        $order_id = (int)$request->get('order_id');
        
        $expiredOrder = Order::find($order_id);

        $address = $request->get('address');
        
        $business_name = $request->get('business_name');
        
        $city = $request->get('city');
        
        $client_id = $request->get('client_id');

        $company_id = $request->get('company_id');
        
        $country = $request->get('country');

        $discount = $request->get('discount');

        $email = $request->get('email');

        $first_name = $request->get('first_name');
        
        $last_name = $request->get('last_name');        

        $phone_number = $request->get('phone_number');
        
        $post_code = $request->get('post_code');        
        
        $mail_option = $expiredOrder->mail_option;

        $virtual_account = $expiredOrder->virtual_account;

        $scan_account = $expiredOrder->virtual_scan_account;
        
        $order = $expiredOrder->replicate();
    
        $client = $order->client;

        $amount = $order->product->amount;

        if ($mail_option === 'forwarding' && $virtual_account) {

            $amount += $virtual_account->credit_amount;

        } else if ($mail_option === 'scanned' && $scan_account) {

            $amount += $scan_account->credit_amount;

        }

        foreach($expiredOrder->included as $i)  {

            $_amount = $i->product->amount;

            foreach($expiredOrder->product->product_extras as $x) {

                if ($x->product_id == $expiredOrder->product_id && $x->extra_product_id == $i->product_id && ($x->included == 1 || $x->price > 0)) {

                    $_amount = $x->price;

                }

            }

            if ($i->code_selected === 'code_207') {

                $_amount += $i->product->code_207_cost;

            }

            if ($i->forward_calls === 1) {

                $_amount += $i->product->forwarding_deposit;
            }            

            $amount += $_amount;

        }

        if ($discount > 0) {

            $total_discount_amount = $amount * $discount / 100;

            $order->discount_percentage = $discount;

            $order->total_discount_amount = $total_discount_amount;

            $amount -= $total_discount_amount;            

            $vat_amount = $amount * 20 / 100;

            $total_amount = $amount + $vat_amount;

            $order->total_amount = $total_amount;            
 
        } else {

            $order->discount_percentage = 0;

            $order->total_discount_amount = 0;

            $vat_amount = $amount * 20 / 100;

            $total_amount = $amount + $vat_amount;

            $order->total_amount = $total_amount;

        }

        $product = Product::find( $order->product_id );

        $order->contract_startdate = $expiredOrder->contract_enddate;

        $enddate = $expiredOrder->contract_enddate;

        $paypal_date = Carbon::now()->addYears(20);

        $contract_length = $order->contract_length;

        if ((int)$contract_length > 0) {

            $enddate = Carbon::parse( $order->contract_startdate )->addDays( $contract_length );

        } else {

            switch ( $product->term ) {

                case 1:

                    $enddate = Carbon::parse( $order->contract_startdate )->addDays( 30 );

                    $contract_length = 30;

                break;

                case 3:

                    $enddate = Carbon::parse( $order->contract_startdate )->addDays( 90 );

                    $contract_length = 90;


                break;

                case 6:

                    $enddate = Carbon::parse( $order->contract_startdate )->addDays( 180 );

                    $contract_length = 180;


                break;

                default:

                    $enddate = Carbon::parse( $order->contract_startdate )->addDays( 365 );

                    $contract_length = 365;

            }

        }

        $order->contract_paypaldate = $paypal_date;

        $order->contract_enddate = $enddate;

        $order->contract_length = $contract_length;

        $order->deleted = 1;

        $order->previous_order_id = $expiredOrder->id;

        $order->expired_status = 1;

        $order->order_status = 0;

        $order->order_date = Carbon::now();

        $order->last_email_sent = Carbon::now();

        $order->reminder_sent = Carbon::now();

        $order->save(); 

        //print_r($order->toArray());
        

        $successURL = url('/api/' . $order->id . '/renew-success');

        $failedURL = url('/api/' . $order->id . '/renew-failed');

        $transactionId = 'RENEW-' . date("YmdHis") . '-' . $order->id;

        list($method, $url, $hiddenFormItems) = $this->sage_processing($client, $order, $successURL, $failedURL, $transactionId);
            
        //$data['url'] = url('/checkout/online-payment');

        //$request->session()->put('sagepay-method', $method);
        //$request->session()->put('sagepay-url', $url);
        //$request->session()->put('sagepay-items', $hiddenFormItems);

        //$response = $gateway->purchase($params)->send();

        //$method = $response->getRedirectMethod();
        //$url = $response->getRedirectUrl();
        //$hiddenFormItems = $response->getRedirectData();        

        //$request->session()->put('sagepay-method', $method);
        //$request->session()->put('sagepay-url', $url);
        //$request->session()->put('sagepay-items', $hiddenFormItems);

        $data['success'] = 1;
        $data['code'] = $order->id;      
        
        $data['method'] = $method;
        $data['url'] = $url;
        $data['items'] = $hiddenFormItems;

        return view('sagepay.form', $data);

    }

    public function sage_processing($client, $order, $successURL, $failedURL, $transactionId ) {

        //echo $transactionId;

        $sage = [
            'vendor' => env('SAGEPAY_VENDOR'),
            'testMode' => env('SAGEPAY_TESTMODE'),
            'encryptionKey' => env('SAGEPAY_KEY')
        ];

        $gateway = OmniPay::create('SagePay\Form')->initialize( $sage );

        $params = [
            'Description' => $order->product_name,
            'card' => [
                'billingFirstName' => $client->first_name,
                'billingLastName' => $client->last_name,
                'billingAddress1' => !empty($client->address) ? $client->address : 'Address',
                'billingCity' => !empty($client->city) ? $client->city : 'London' ,
                'billingPostcode' => !empty($client->post_code) ? $client->post_code : 'HP27DX',
                'billingCountry' => 'GB',
                'billingState' => 'London',
                'billingPhone' => $client->phone_number
            ],

            'transactionId' => $transactionId,
            
            //'amount' => $order->total_amount,
            'amount' => round($order->total_amount, 2),
            'currency' => 'GBP',
            
            'billingForShipping' => true,

            'shippingFirstName' => $client->first_name,
            'shippingLastName' => $client->last_name,
            'shippingAddress1' => !empty($client->address) ? $client->address : 'Address',
            'shippingCity' => !empty($client->city) ? $client->city : 'London' ,
            'shippingPostcode' => !empty($client->post_code) ? $client->post_code : 'HP27DX',
            'shippingCountry' => 'GB',

            'returnUrl' => $successURL,
            'failureUrl' => $failedURL,
        ];       

        //print_r($params);

        $response = $gateway->purchase($params)->send();

        $method = $response->getRedirectMethod();
        
        $url = $response->getRedirectUrl();
        
        $hiddenFormItems = $response->getRedirectData();   
       
        return [$method, $url, $hiddenFormItems];

    }

    public function renewSuccess($order_id) {

        $gateway = OmniPay::create('SagePay\Form')->initialize([
            'vendor' => env('SAGEPAY_VENDOR'),
            'testMode' => env('SAGEPAY_TESTMODE'),
            'encryptionKey' => env('SAGEPAY_KEY')
        ]);        

        $order = Order::find($order_id);

        $expiredOrder = Order::find( $order->previous_order_id );

        $expiredOrder->expired_status = 1;
        $expiredOrder->block_status = 1;
        $expiredOrder->order_status = 0;

        $expiredOrder->save();

        $client_id = $order->client_id;

        $company_id = $order->company_id;        
        
        $transaction_id = "";

        $test = false;

        if ($test || isset($_GET['crypt'])) {

            $crypt = $_GET['crypt']; 

            $crypt_valid = SageTransaction::where('crypt', '=', $crypt)->get()->count() === 0;

            if ( $test || $crypt_valid ) {
        
                $response = $gateway->completePurchase(['crypt' => $crypt])->send();

                $response->payment_type = 1;
                
                $transaction_id = $response->getTransactionId();

                //$order_data = $this->check_order_details($order);

                $renewal = new OrderRenewal;

                $renewal->amount_paid = $order->total_amount;
            
                $renewal->order_id = $order->id;
            
                $renewal->date = date("Y-m-d");
            
                $renewal->user_id = 0;

                $renewal->save();

                $order->deleted = 0;

                $order->expired_status = 0;

                $order->order_status = 1;

                $order->save();

                foreach($order->groups as $g) {

                    $g->deleted = 0;
                    $g->expired_status = 0;
                    $g->order_status = 1;

                    $g->save();

                    foreach($g->extras as $x) {

                        $x->deleted = 0;
                        $x->expired_status = 0;
                        $x->order_status = 1;

                        $x->save();

                    }

                }

                $sage = new SageTransaction;

                $sage->client_id = $client_id;
                $sage->crypt = $crypt;

                $transaction = $sage->update_transactions( $order_id, $response, 'online');

                $pdf_file = $this->pdf_generate($order_id);

                $files = [];

                $files[] = $pdf_file;

                foreach($order->extras as $x) {
                    if (!empty($x->product->file)) {
                        $files[] = $_SERVER['DOCUMENT_ROOT'] . 'storage/files/clients/documents/' . $x->product->file;
                    }
                }                

                $admin_email = $this->adminOrderAddEmail(sprintf("%s %s", $order->client->first_name, $order->client->last_name), $order_id, $files, $order->company_id);

                $order_email = $this->orderAddEmail($order->client->email, sprintf("%s %s", $order->client->first_name, $order->client->last_name), $order, $files, $order->company_id);

            }

            return response()->json(['order' => $order, 'status' => 'success']);

        }
    }

    public function adminOrderAddEmail($client_name = null, $order_id = null, $file = null, $company_id = null) {
        
        $template = EmailTemplate::where('static_email_heading', '=', 'ADMIN_ORDER_ADD')->first();

        $user_email_contents = $template->template;

        $order = Order::find($order_id);

        $flag = false;

        $order = Order::find( $order_id );

        if (!empty ($user_email_contents)) {
            
            $str = ['[client_name]', '[order_id]', '[site_address]', '[site_name]', '[company_name]', '[product_name]', '[amount]'];
            
            $val = [$client_name, $order_id, URL::to('/'), config('app.name'), $order->company->name, $order->product_name, number_format($order->total_amount, 2)];

            $user_email_message = str_replace($str, $val, $user_email_contents);

            $body = ['messageBody' => $user_email_message, 'http_host' => sprintf("https://%s", $_SERVER['HTTP_HOST'])];

            $user_email_body = view('mail.body', $body)->render();

            $user_subject = $template->subject;
            
            //$info_email = Setting::where('name', '=', 'info_email')->first()->value;
            
            //$info_name = Setting::where('name', '=', 'info_name')->first()->value;

            //$admin_email = Setting::where('name', '=', 'admin_email')->first()->value;

            //$this->pushEmailToQueue($admin_email, $info_name, $info_email, $info_name, $user_subject, $user_email_body, 'ORDER PLACED-ADMIN', '', '', '', $file, 1);

            $mail = new SendMailable($user_email_message, $user_subject);

            //$admin_email = 'celsomalacasjr@gmail.com';
            $admin_email = 'info@capital-office.co.uk';

            $mail->files = $file;

            $mail->mail = $admin_email;

            $mail->template = 'ADMIN ORDER ADD';

            $mail->process_name = 'ADMIN ORDER ADD';

            $mail->show_to_client = 0;

            $mail->to_name = 'Capitalf Office';

            $mail->to_email = $admin_email;

            $mail->company_id = $order->company_id;

            Mail::to($mail->mail)->send($mail);

            //dispatch(new sendMailJob($mail))->delay(Carbon::now()->addSeconds(5));    
            
            $flag = true;
        }        
        
        return $flag;
    }

    public function orderAddEmail($client_email = null, $client_name = null, $order = null, $files = null, $company_id = null, $type = null) {
        // To send the email notification to admin
        
        $template = EmailTemplate::where('static_email_heading', '=', 'CLIENT_REGISTRATION')->first();

        $user_email_contents = $template->template;
        
        $flag = false;

        if (!empty($user_email_contents)) {

            $client = $order->client;

            $full_name = sprintf("%s %s", $client->first_name, $client->last_name);

            $email = $client->email;

            //$password = $this->generate_password();

            //$client->password = Hash::make($password);
            
            //$client->save();

            $str = ['[email]', '[client_name]', '[site_address]', '[site_name]', '[user_name]'];

            $val = [$email, $full_name, URL::to('/'),  config('app.name'), $full_name];

            $user_email_message = str_replace($str, $val, $user_email_contents);

            if (!empty($type))  {
                $user_email_message = str_ireplace('Thank you for ordering the product', 'Recurring payment successfull for your product', $user_email_message);
            }

            //$body = ['messageBody' => $user_email_message, 'http_host' => sprintf("https://%s", $_SERVER['HTTP_HOST'])];

            //$user_email_body = view('mail.body', $body)->render();

            $user_subject = $template->subject;

            $info_email = Setting::where('name', '=', 'info_email')->first()->value;
            
            $info_name = Setting::where('name', '=', 'info_name')->first()->value;
            
            $client_name = !empty($client_name) ? $client_name : '';

            //$client_email = 'celsomalacasjr@gmail.com';

            //$this->pushEmailToQueue($client_email, $client_name, $info_email, $info_name, $user_subject, $user_email_body, 'ORDER PLACED', '', '', $company_id, $file, 1);

            $mail = new SendMailable($user_email_message, $user_subject);

            $mail->files = $files;

            $mail->mail = $client_email;

            $mail->template = 'ORDER ADD';

            $mail->process_name = 'ORDER ADD';

            $mail->show_to_client = 1;

            $mail->to_name = $client_name;

            $mail->to_email = $client_email;

            $mail->company_id = $order->company_id;

            Mail::to($mail->mail)->send($mail);

            //dispatch(new sendMailJob($mail))->delay(Carbon::now()->addSeconds(5));    

            //Mail::to($mail->mail)->send($mail);        
            
            $flag = true;
        }

        return $flag;
    }

    public function pdf_generate($order_id = null, $type = null)  {
        if (!empty($order_id)) {

            try {

                $order = Order::find($order_id);

                $company = $order->company;        

                $order->product;
                
                $order->client;

                $data['order'] = $order;
            
                $pdf = DOMPDF::loadView('orders.invoice', $data);

                $destination_folder = $_SERVER['DOCUMENT_ROOT'] . '/storage/files/clients/order_pdf/';
                
                $file_name = 'Order-' . $order->id . ".pdf";
                
                $newFilePath = $destination_folder . $file_name;            

                $pdf->save($newFilePath);            

                return $newFilePath;


            } catch ( \Exception $exception ) {

                Log::error( $exception );
    
            }
            
                         
            
        }
        else
        {
            return false;
        }
    }

    private function check_order_details($order) {

        $today = Carbon::now();

        $start_date = Carbon::now();

        $end_date = Carbon::now();

        $product = $order->product;

        $term = $product->term;

        
        foreach($product->included as $x) {
            if ( $x->product && $x->product->term > $term ) {
                $term = $x->product->term;
            }
        }        

        $end_date = Carbon::parse( $order->contract_startdate )->addDays( $order->contract_length );

        $paypal_date = Carbon::parse( $order->contract_startdate )->addYears(20);

        $order->order_date = Carbon::now();

        $order->contract_startdate = $start_date;

        $order->contract_enddate = $end_date;

        $order->contract_paypaldate = $paypal_date;

        $order->product_name = $order->product->name;

        $order->deleted = 0;

        $order->expired_status = 0;

        $order->order_status = 1;

        $order->save();

        $expiredOrder = Order::find($order->previous_order_id);

        $expiredOrder->block_status = 1;

        $expiredOrder->save();

        return $order;

    }

    public function payNewService(Request $request) {

        $client_id = $request->get('client_id');

        $company_id = $request->get('company_id');

        $product_id = $request->get('product_id');

        //$product = Product::find($product_id);

        $client = Client::find($client_id);

        $items = json_decode($request->get('cart_items'), true);

        $item = array_shift($items);

        $product = Product::find($item['id']); 

        $amount = $item['amount'];

        if (isset($item['sub_list'])) {

            foreach($item['sub_list'] as $s) {

                $amount += $s['amount'];

            }

        }

        foreach($items as $i) {

            $amount += $i['amount'];

            if (isset($i['sub_list'])) {

                foreach($i['sub_list'] as $s) {
    
                    $amount += $s['amount'];
    
                }
    
            }

        }        

        $discount = $request->get('coupon');

        $order = new Order;

        $order->client_id = $client_id;

        $order->company_id = $company_id;

        $order->product_id = $product->id;

        $order->amount = $amount;

        $order->product_name = $product->name;

        $order->contract_startdate = Carbon::now();

        switch ( $product->term ) {

            case 1:

                $enddate = Carbon::parse( $order->contract_startdate )->addDays( 30 );
                $contract_length = 30;

            break;

            case 3:

                $enddate = Carbon::parse( $order->contract_startdate )->addDays( 90 );
                $contract_length = 90;


            break;

            case 6:

                $enddate = Carbon::parse( $order->contract_startdate )->addDays( 180 );
                $contract_length = 180;


            break;

            default:

                $enddate = Carbon::parse( $order->contract_startdate )->addDays( 365 );
                $contract_length = 365;

        }

        if ($discount > 0) {

            $total_discount_amount = $amount * $discount / 100;

            $order->discount_percentage = $discount;

            $order->total_discount_amount = $total_discount_amount;

            $amount -= $total_discount_amount;

            $vat_amount = $amount * 20 / 100;

            $total_amount = $amount + $vat_amount;

            $order->total_amount = $total_amount;            
 
        } else {

            $order->discount_percentage = 0;

            $order->total_discount_amount = 0;

            $vat_amount = $amount * 20 / 100;        

            $total_amount = $amount + $vat_amount;

            $order->total_amount = $total_amount;

        }
        
        

        //$product = Product::find( $order->product_id );

        //$order->contract_startdate = $expiredOrder->contract_enddate;

        //$enddate = $expiredOrder->contract_enddate;

        $paypal_date = Carbon::now()->addYears(20);

        $contract_length = 0; //$order->contract_length;

        
            switch ( $product->term ) {

                case 1:

                    $enddate = Carbon::parse( $order->contract_startdate )->addDays( 30 );

                    $contract_length = 30;

                break;

                case 3:

                    $enddate = Carbon::parse( $order->contract_startdate )->addDays( 90 );

                    $contract_length = 90;


                break;

                case 6:

                    $enddate = Carbon::parse( $order->contract_startdate )->addDays( 180 );

                    $contract_length = 180;


                break;

                default:

                    $enddate = Carbon::parse( $order->contract_startdate )->addDays( 365 );

                    $contract_length = 365;

            }

       
        $order->contract_paypaldate = $paypal_date;

        $order->contract_enddate = $enddate;

        $order->contract_length = $contract_length;

        $order->deleted = 1;
        $order->previous_order_id = 0; //$expiredOrder->id;
        $order->expired_status = 1;
        $order->order_status = 0;

        $order->order_date = Carbon::now();

        $order->last_email_sent = Carbon::now();

        $order->reminder_sent = Carbon::now();

        $order->save(); 

        $group_order_id = $order->id;

        if (isset($item['sub_list'])) {

            $sublist = $item['sub_list'];

            foreach($sublist as $s) {

                $extra = new Order;

                $extra->client_id = $order->client_id;
                $extra->company_id = $order->company_id;

                $x_product = Product::find($s['id']);

                switch ( $x_product->term ) {

                    case 1:

                        $enddate = Carbon::parse( $order->contract_startdate )->addDays( 30 );
                        $contract_length = 30;

                    break;

                    case 3:

                        $enddate = Carbon::parse( $order->contract_startdate )->addDays( 90 );
                        $contract_length = 90;


                    break;

                    case 6:

                        $enddate = Carbon::parse( $order->contract_startdate )->addDays( 180 );
                        $contract_length = 180;


                    break;

                    default:

                        $enddate = Carbon::parse( $order->contract_startdate )->addDays( 365 );
                        $contract_length = 365;

                }

                $extra->contract_startdate = $order->contract_startdate;
                $extra->contract_enddate = $enddate;
                $extra->contract_length = $contract_length;

                $extra->product_id = $s['id'];
                $extra->product_name = $s['name'];
                $extra->package_order_id = $order->id;
                $extra->group_order_id = $group_order_id;

                $extra->order_date = Carbon::now();
                $extra->last_email_sent = Carbon::now();
                $extra->reminder_sent = Carbon::now();

                $extra->deleted = 1;
                $extra->expired_status = 1;
                $extra->order_status = 0;

                $x_amount = $s['amount'];

                $x_total_discount = $x_amount * $discount / 100;

                $x_amount -= $x_total_discount;

                $extra->amount = $s['amount'];
                $extra->total_amount = $x_amount  + ($x_amount * 0.2);
            
                $extra->save();

            }

        }

        foreach($items as $i) {

            $extra = new Order;

            $extra->client_id = $order->client_id;
            $extra->company_id = $order->company_id;

            $x_product = Product::find($i['id']);

            switch ( $x_product->term ) {

                case 1:

                    $enddate = Carbon::parse( $order->contract_startdate )->addDays( 30 );
                    $contract_length = 30;

                break;

                case 3:

                    $enddate = Carbon::parse( $order->contract_startdate )->addDays( 90 );
                    $contract_length = 90;


                break;

                case 6:

                    $enddate = Carbon::parse( $order->contract_startdate )->addDays( 180 );
                    $contract_length = 180;


                break;

                default:

                    $enddate = Carbon::parse( $order->contract_startdate )->addDays( 365 );
                    $contract_length = 365;

            }

            $extra->contract_startdate = $order->contract_startdate;
            $extra->contract_enddate = $enddate;
            $extra->contract_length = $contract_length;

            $extra->product_id = $i['id'];
            $extra->product_name = $i['name'];
            $extra->package_order_id = $order->id;
            $extra->group_order_id = $group_order_id;

            $extra->order_date = Carbon::now();
            $extra->last_email_sent = Carbon::now();
            $extra->reminder_sent = Carbon::now();

            $extra->deleted = 1;
            $extra->expired_status = 1;
            $extra->order_status = 0;

            $x_amount = $i['amount'];

            $x_total_discount = $x_amount * $discount / 100;

            $x_amount -= $x_total_discount;

            $extra->amount = $i['amount'];
            $extra->total_amount = $x_amount  + ($x_amount * 0.2);
            
            $extra->save();

            if (isset($item['sub_list'])) {

                $sublist = $item['sub_list'];
    
                foreach($sublist as $s) {
    
                    $sub = new Order;
    
                    $sub->client_id = $order->client_id;
                    $sub->company_id = $order->company_id;
    
                    $x_product = Product::find($s['id']);
    
                    switch ( $x_product->term ) {
    
                        case 1:
    
                            $enddate = Carbon::parse( $order->contract_startdate )->addDays( 30 );
                            $contract_length = 30;
    
                        break;
    
                        case 3:
    
                            $enddate = Carbon::parse( $order->contract_startdate )->addDays( 90 );
                            $contract_length = 90;
    
    
                        break;
    
                        case 6:
    
                            $enddate = Carbon::parse( $order->contract_startdate )->addDays( 180 );
                            $contract_length = 180;
    
    
                        break;
    
                        default:
    
                            $enddate = Carbon::parse( $order->contract_startdate )->addDays( 365 );
                            $contract_length = 365;
    
                    }
    
                    $sub->contract_startdate = $order->contract_startdate;
                    $sub->contract_enddate = $enddate;
                    $sub->contract_length = $contract_length;
    
                    $sub->product_id = $s['id'];
                    $sub->product_name = $s['name'];
                    $sub->package_order_id = $extra->id;
                    $sub->group_order_id = $group_order_id;
    
                    $sub->order_date = Carbon::now();
                    $sub->last_email_sent = Carbon::now();
                    $sub->reminder_sent = Carbon::now();
    
                    $sub->deleted = 1;
                    $sub->expired_status = 1;
                    $sub->order_status = 0;
    
                    $x_amount = $s['amount'];
    
                    $x_total_discount = $x_amount * $discount / 100;
    
                    $x_amount -= $x_total_discount;
    
                    $sub->amount = $s['amount'];
                    $sub->total_amount = $x_amount  + ($x_amount * 0.2);
                
                    $sub->save();
    
                }
    
            }
        }
        

        $successURL = url('/api/' . $order->id . '/new-service-success');

        $failedURL = url('/api/' . $order->id . '/new-service-failed');

        $transactionId = 'NEW-SERVICE-' . date("YmdHis") . '-' . $order->id;

        list($method, $url, $hiddenFormItems) = $this->sage_processing($client, $order, $successURL, $failedURL, $transactionId);
            
        //$data['url'] = url('/checkout/online-payment');

        //$request->session()->put('sagepay-method', $method);
        //$request->session()->put('sagepay-url', $url);
        //$request->session()->put('sagepay-items', $hiddenFormItems);

        //$response = $gateway->purchase($params)->send();

        //$method = $response->getRedirectMethod();
        //$url = $response->getRedirectUrl();
        //$hiddenFormItems = $response->getRedirectData();        

        //$request->session()->put('sagepay-method', $method);
        //$request->session()->put('sagepay-url', $url);
        //$request->session()->put('sagepay-items', $hiddenFormItems);

        $data['success'] = 1;
        $data['code'] = $order->id;      
        
        $data['method'] = $method;
        $data['url'] = $url;
        $data['items'] = $hiddenFormItems;

        return view('sagepay.form', $data);

    }

    public function newServiceSuccess($order_id) {

        $gateway = OmniPay::create('SagePay\Form')->initialize([
            'vendor' => env('SAGEPAY_VENDOR'),
            'testMode' => env('SAGEPAY_TESTMODE'),
            'encryptionKey' => env('SAGEPAY_KEY')
        ]);        

        $order = Order::find($order_id);

        $client_id = $order->client_id;
        $company_id = $order->company_id;        
        
        $transaction_id = "";

        $test = false;

        if ($test || isset($_GET['crypt'])) {

            $crypt = $_GET['crypt']; 

            $crypt_valid = SageTransaction::where('crypt', '=', $crypt)->get()->count() === 0;

            if ( $test || $crypt_valid ) {
        
                $response = $gateway->completePurchase(['crypt' => $crypt])->send();

                $response->payment_type = 1;
                
                $transaction_id = $response->getTransactionId();

                //$order_data = $this->check_order_details($order);

                $order->deleted = 0;

                $order->expired_status = 0;

                $order->order_status = 1;

                $order->save();

                $groups = $order->groups;

                foreach($order->groups as $g) {

                    $g->deleted = 0;
                    $g->expired_status = 0;
                    $g->order_status = 1;

                    $g->save();

                    foreach($g->extras as $x) {

                        $x->deleted = 0;
                        $x->expired_status = 0;
                        $x->order_status = 1;

                        $x->save();

                    }

                }

                $sage = new SageTransaction;

                $sage->client_id = $client_id;
                $sage->crypt = $crypt;

                $transaction = $sage->update_transactions( $order_id, $response, 'online');

                $pdf_file = $this->pdf_generate($order_id);

                $files = [];

                $files[] = $pdf_file;

                foreach($order->extras as $x) {
                    if (!empty($x->product->file)) {
                        $files[] = $_SERVER['DOCUMENT_ROOT'] . 'storage/files/clients/documents/' . $x->product->file;
                    }
                }                

                $admin_email = $this->adminOrderAddEmail(sprintf("%s %s", $order->client->first_name, $order->client->last_name), $order_id, $files, $order->company_id);

                $order_email = $this->orderAddEmail($order->client->email, sprintf("%s %s", $order->client->first_name, $order->client->last_name), $order, $files, $order->company_id);

            }

            return response()->json(['order' => $order, 'status' => 'success']);

        }
    }


    public function invoiceSuccess($id) {

        $gateway = OmniPay::create('SagePay\Form')->initialize([
            'vendor' => env('SAGEPAY_VENDOR'),
            'testMode' => env('SAGEPAY_TESTMODE'),
            'encryptionKey' => env('SAGEPAY_KEY')
        ]);

        $invoice = InvoiceMaster::find($id);

        $client_id = $invoice->client_id;
        $company_id = $invoice->company_id;

        $client = Client::find($client_id);

        $company = Company::find($company_id);
       

        if (isset($_GET['crypt'])) {

            $crypt = $_GET['crypt']; 
        
            $response = $gateway->completePurchase(['crypt' => $crypt])->send();

            $transaction_id = $response->getTransactionId();

            $invoice->paid_at = date("Y-m-d H:i:s");

            $invoice->save();

            $sage = new SageTransaction;

            $sage->client_id = $client_id;

            $res = SageTransaction::where('invoice_id', '=', $id)->get();

            if ($res->isEmpty()) {

                $response->payment_type = 1;
                $transaction = $sage->update_invoice_transactions($id, $response, 'online');
                
            }

            $client_name = sprintf("%s %s", $client->first_name, $client->last_name);

            $content = sprintf("%s paid the invoice #: %s", $client_name, $id);

            $subject = sprintf("INVOICE NUMBER %s PAID - COMPANY NAME %s", $id, $company->name);

            $admin = new SendMailable($content, $subject);

            $admin->to_email = 'info@capital-office.co.uk';
            $admin->to_name = 'Capital Office';
            $admin->email = 'info@capital-office.co.uk';

            //Mail::to($admin->email)->send($admin);

            //dispatch(new sendMailJob($admin))->delay(Carbon::now()->addSeconds(5));    
                        

        }

        return response()->json(['invoice' => $invoice, 'status' => 'success']);

    }

    public function getCompanyInformation($id) {

        $company = Company::select(
                        'companies.*',
                        DB::raw('company_informations.answer_1'),
                        DB::raw('company_informations.answer_2'),
                        DB::raw('company_informations.answer_3'),
                        DB::raw('company_informations.answer_4'),
                        DB::raw('company_informations.answer_5'),
                        DB::raw('company_informations.phone_script')
                    )
                    ->whereRaw('companies.id = ' . $id)
                    ->leftJoin('company_informations', 'company_informations.company_id', '=', 'companies.id')
                    ->first();
        
        return response()->json(['company' => $company]);

    }

    public function saveCompanyInformation(Request $request) {

        $id  = $request->get('company_id');

        $answer_1 = $request->get('answer_1');

        $answer_2 = $request->get('answer_2');

        $answer_3 = $request->get('answer_3');

        $answer_4 = $request->get('answer_4');

        $answer_5 = $request->get('answer_5');

        $company = CompanyInformation::firstOrNew(['company_id' => $id]);

        $company->company_id = $id;

        $company->answer_1 = $answer_1;

        $company->answer_2 = $answer_2;

        $company->answer_3 = $answer_3;

        $company->answer_4 = $answer_4;

        $company->answer_5 = $answer_5;

        $company->created_user_id = auth()->id();

        $company->modified_user_id = auth()->id();

        $company->save();

        return $this->getCompanyInformation($id);

    }

    public function saveNewAccount(Request $request) {

        $company = new Company;

        $current = $company->toArray();

        $website = $request->get('website');
 
        if (!empty($website) && preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website))
        {
            if (!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $website))
            {
                $website = 'http://' . $website;
            }
        }

        $company->name = $request->get('name');
        $company->email = $request->get('email');
        
        $company->client_id = $request->get('client_id');
        
        $company->user_id = 9999;
        
        $company->phone_number = $request->get('phone_number');
        $company->known_as = (string)$request->get('known_as');
        $company->website = (string)$website;
        $company->city = (string)$request->get('city');
        
        $company->company_type = (string)$request->get('company_type');

        $company->address_1 = (string)$request->get('address');
        $company->post_code = (string)$request->get('post_code');
        $company->industry = $request->get('company_type');
        $company->status = 1;

        $company->save();

        $client = Client::find($request->get('client_id'));

        $this->save_log( $current, $company, 'Company', $client);

        return response()->json(['success' => 1], 200, [], JSON_NUMERIC_CHECK);

    }
    
}
