<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

use DB;

class Client extends Authenticatable
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    
    use HasApiTokens, Notifiable;

    protected $guarded = ['id'];

    protected $table = 'clients';

    protected $hidden = [
        'password',
        'remember_token',
        'access_token'
    ];

    public function getAuthPassword() {
        return $this->password;
    }

    public function generateToken($client) {
        return $client->createToken();
    }

    public function companies() {
        return $this->hasMany('App\Company')
                ->where('deleted', '=', 0)
                ->orderBy('status', 'desc')
                ->orderBy('name');
    }

    public function invoices() {

        return $this->hasMany('App\InvoiceMaster', 'client_id');

    }

    public function orders() {
        return $this->hasMany('App\Order', 'client_id')
                ->select(
                        'orders.*', 
                        DB::raw('products_v2.term as product_term'),
                        DB::raw('products_v2.type as product_type'),
                        DB::raw('products_v2.name as order_product_name'),
                        DB::raw('companies.name as company_name')
                    )
                ->join('companies', 'companies.id', '=', 'orders.company_id')
                ->join('products_v2', 'products_v2.id', '=', 'orders.product_id')
                ->where('orders.deleted', '=', 0)
                ->orderBy('contract_enddate', 'desc')
                ->orderBy('order_status', 'desc')
                ->orderBy('expired_status', 'asc');
    }

    public function orders_desc() {
        return $this->hasMany('App\Order', 'client_id')
                ->select('orders.*')
                ->join('companies', 'companies.id', '=', 'orders.company_id')
                ->join('products_v2', 'products_v2.id', '=', 'orders.product_id')
                ->where('orders.deleted', '=', 0)
                ->orderBy('contract_enddate', 'desc')
                ->orderBy('order_status', 'desc');
    }

    public function bookings() {
        return $this->hasMany('App\Booking', 'client_id')->where('deleted', '=', 0)->orderBy('date', 'desc');
    }

    public function virtual_accounts() {
        return $this->hasMany('App\VirtualAccount', 'client_id')
                ->select('virtual_accounts.*', DB::raw('( SELECT SUM(v2.credit_amount - v2.debit_amount) FROM virtual_accounts v2 WHERE v2.client_id = virtual_accounts.client_id AND v2.id <= virtual_accounts.id AND v2.payment_status = 2 ) as balance'))
                ->where('virtual_accounts.payment_status', '=', 2)
                ->orderBy('virtual_accounts.created', 'desc');
    }

    public function virtual_scan_accounts() {
        return $this->hasMany('App\VirtualScanAccount', 'client_id')
                ->where('payment_status', '=', 2)
                ->orderBy('created', 'desc');
    }

    public function sagetransactions() {
        return $this->hasManyThrough('App\SageTransaction', 'App\Order', 'client_id')
                ->where('orders.deleted', '=', 0)
                ->orderBy('sagetransactions.created', 'desc');
    }

    public function transactions() {
        return $this->hasMany('App\Transaction', 'client_id');
    }
    
    public function tasks() {
        return $this->hasMany('App\Task', 'client_id');
    }

    public function scan_accounts() {
        return $this->hasMany('App\ScanAccount', 'client_id')
                    ->select('scan_accounts.*', DB::raw('((SELECT SUM(credit_quantity - debit_quantity) 
                                                           FROM scan_accounts sa2 
                                                           WHERE 
                                                                sa2.client_id = scan_accounts.client_id AND 
                                                                sa2.id <= scan_accounts.id) - (SELECT SUM(scan_quantity) FROM mail_log_letters WHERE mail_log_letters.scan_charge = 1 AND company_id IN (SELECT id FROM companies WHERE client_id = scan_accounts.client_id))) as balance'))
                    ->whereRaw('scan_accounts.payment_status = 2')
                    ->orderBy(DB::raw('scan_accounts.created'), 'desc');
    }

    public function generate_password() {
        
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        $length = 10;
        
        $randomString = '';
        
        for($i = 0; $i < $length; $i ++) {
    		$randomString .= $characters [rand ( 0, strlen ( $characters ) - 1 )];
    	}
        
        return $randomString;
    }

    public function lead_orders() {
        return $this->hasMany('App\Order', 'weblead_id');
    }

    public function forwarding_emails() {
        return $this->hasMany('App\ClientForwardingEmail');
    }

    public function referral_histories() {
        return $this->hasMany('App\ReferralHistory', 'referral_client_id');
    }

    public function directors() {
        return $this->hasMany('App\Director', 'client_id')
                ->select('directors.*', DB::raw('DATE(directors.dob) AS dob'));
    }

    public function partners() {
        return $this->hasMany('App\Partner', 'client_id');
    }

    public function members() {
        return $this->hasMany('App\Member', 'client_id');
    }

    public function change_logs() {
        
        return $this->hasMany('App\ChangeLog', 'table_id')
                    ->where('table_name', '=', 'Clients')
                    ->orderBy('change_logs.created', 'desc');                                        
    }

    public function post_logs() {

        return $this->hasManyThrough('App\MailLogLetter', 'App\Company')
                    ->select('mail_log_letters.*', 
                            DB::raw('products_v2.name as product_name'),
                            DB::raw('companies.name as company_name')
                            )
                    ->join('products_v2', 'products_v2.id','=', 'mail_log_letters.product_id')                    
                    ->orderBy('mail_log_letters.created_at', 'desc')
                    ->where('mail_log_letters.deleted', '=', 0);

    }

    public function client_post_logs() {

        return $this->hasManyThrough('App\MailLogLetter', 'App\Company')
                    ->select('mail_log_letters.*', 
                            DB::raw('products_v2.name as product_name'),
                            DB::raw('companies.name as company_name')
                            )
                    ->join('products_v2', 'products_v2.id','=', 'mail_log_letters.product_id')                    
                    ->orderBy('mail_log_letters.created_at', 'desc')
                    ->where('mail_log_letters.notify', '=', 1)
                    ->where('mail_log_letters.deleted', '=', 0);

    }

    public function affiliates() {

        return $this->hasMany('App\Order', 'affiliate_id')
                    ->select('orders.*', 
                                DB::raw('companies.name as company_name'), 
                                DB::raw('CONCAT(clients.first_name, " ", clients.last_name) as client_name') )
                    ->join('companies', 'companies.id', '=', 'orders.company_id')
                    ->join('clients', 'clients.id', '=', 'orders.client_id')
                    ->orderBy('orders.created', 'desc')
                    ->where('orders.deleted', '=', 0);

    }

    public function alerts() {

        return $this->hasManyThrough('App\CompanyAlert', 'App\Company')
                    ->select('company_alerts.*', 
                              DB::raw('companies.name as company_name'),
                              DB::raw('new_users.first_name as user_first_name'), 
                              DB::raw('new_users.last_name as user_last_name'),
                              DB::raw('CONCAT(new_users.first_name, " ", new_users.last_name) as user_name')
                            )
                    ->join('new_users', 'new_users.id', '=', 'company_alerts.user_id')
                    ->orderBy('company_alerts.created', 'desc')
                    ->where('company_alerts.type', '=', 0);
                    

    }

    public function notes() {

        return $this->hasManyThrough('App\CompanyNote', 'App\Company')
                    ->select('company_notes.*',
                              DB::raw('companies.name as company_name'),
                              DB::raw('CONCAT(new_users.first_name, " ", new_users.last_name) as user_name')
                        )                    
                    ->join('new_users', 'new_users.id', '=', 'company_notes.user_id')
                    ->orderBy('company_notes.created', 'desc');

    }

    public function services() {

        return $this->hasMany('App\Order', 'client_id')
                ->select(
                    'orders.*',
                    DB::raw('products_v2.name as product_name'),
                    DB::raw('companies.name as company_name'),
                    DB::raw('products_v2.term as product_term'),
                    DB::raw('products_v2.type as product_type'),
                    DB::raw('products_v2.recurring_type as product_recurring_type'),
                    DB::raw('term as product_term')
                )
                ->join('products_v2', 'products_v2.id', '=', 'product_id')
                ->join('companies', 'companies.id', '=', 'company_id')
                ->where('orders.type', '=', 0)
                ->where('orders.deleted', '=', 0)
                ->where('companies.deleted', '=', 0)
                ->whereRaw('(
                    (products_v2.type = 3) OR 
                    (
                        (products_v2.recurring_type = 1 OR products_v2.term > 0) && 
                        (products_v2.type = 2)
                    ) OR 
                    (
                        products_v2.v2 = 0 && 
                        (
                            products_v2.type = 0 OR products_v2.type = 2
                        )
                    ))');

    }
}
