<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Company extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $attributes = [
        'known_as' => '',
        'address_1' => '',
        'deleted' => 0,
        'risk_profile' => 0,
        'country' => 'uk',
        'industry' => 0,
        'address_2' => '',
        'forwarding_address_1' => '',
        'forwarding_address_2' => '',
        'forwarding_city' => '',
        'forwarding_post_code' => '',
        'forwarding_country' => 'uk',
        'additional_name1' => '',
        'additional_name2' => '',
        't_mailbox_number' => '',
        't_telephone_number' => '',
        't_phone_number' => '',
        't_voicemail_number' => '',
        't_frequency' => '',
        't_day_of_week' => '',
        't_scanning_frequency' => '',
        'user_id' => 1,
        'email' => '',
        'phone_number' => '',
        'website' => '',
        'city' => '',
        'post_code' => '',
        'quickbookid' => '',
        
    ];

    public function client() {
        return $this->belongsTo('App\Client');
    }

    public function alerts() {
        return $this->hasMany('App\CompanyAlert')->orderby('id', 'desc');
    }

    public function orders() {
        return $this->hasMany('App\Order')
                ->select('orders.*')
                ->join('clients', 'clients.id','=', 'orders.client_id')
                ->join('products_v2', 'products_v2.id', '=', 'orders.product_id')
                ->orderBy('expired_status', 'asc')
                ->orderBy('orders.created', 'desc')
                ->where('orders.deleted', '=', 0);
    }

    public function directors() {
        return $this->hasMany('App\Director')
                    ->select('directors.*', DB::raw('DATE(directors.dob) AS dob'));
    }

    public function partners() {
        return $this->hasMany('App\Partner');
    }

    public function members() {
        return $this->hasMany('App\Member');
    }

    public function scan_accounts() {
        return $this->hasMany('App\ScanAccount');
    }

    public function logging_posts() {
        return $this->hasMany('App\LoggingPost')->orderBy('order_date', 'desc');
    }

    public function emails() {
        return $this->hasMany('App\EmailQueue', 'company_id')->orderBy('created', 'desc');
    }

    public function forwarding_emails() {
        return $this->hasMany('App\ClientForwardingEmail', 'client_id');
    }

    public function notes() {
        return $this->hasMany('App\CompanyNote')
                    ->select(
                        'company_notes.*',
                        DB::raw('CONCAT(new_users.first_name, " ", new_users.last_name) as agent_name')
                    )
                    ->join('new_users', 'new_users.id', '=', 'user_id')
                    ->orderBy('created', 'desc');
    }

    public function invoices() {
        return $this->hasMany('App\InvoiceMaster')
                    ->select('invoice_master.*', DB::raw('CONCAT(first_name, " ", last_name) as agent_name'))
                    ->leftJoin('new_users', 'new_users.id', '=', 'invoice_master.agent_id');
    }

    public function documents() {
        return $this->hasMany('App\CompanyDocument');
    }

    public function info() {
        return $this->hasOne('App\CompanyInformation');
    }
    public function change_logs() {
        return $this->hasMany('App\ChangeLog', 'table_id')
                ->whereIn('table_name', ['Companies', 'Log Post'])
                ->orderBy('modified', 'desc');
    }

    public function order_packages() {
        return $this->hasMany('App\Order')->orderBy('id', 'desc')->where('deleted', '=', 0)->where('package_order_id', '=', 0);
    }

    public function post_logs() {
        
        return $this->hasMany('App\MailLogLetter')
                ->select(
                        'mail_log_letters.*',
                        DB::raw('products_v2.name as product_name'), 
                        DB::raw('IF(mail_log_letters.post_by > 0, CONCAT(new_users.first_name, " ", new_users.last_name), "Not Specified") as agent'),
                        DB::raw('IF(mail_log_letters.held_by > 0, CONCAT(held_users.first_name, " ", held_users.last_name), "Not Specified") as held_agent')
                        )
                ->leftJoin("new_users", 'new_users.id', '=', 'mail_log_letters.post_by')
                ->leftJoin(DB::raw("new_users as held_users"), 'held_users.id', '=', 'mail_log_letters.held_by')
                ->join('products_v2', 'products_v2.id', '=', 'mail_log_letters.product_id')
                ->orderBy('mail_log_letters.updated_at', 'desc')
                ->orderBy('mail_log_letters.id', 'desc')
                ->where('mail_log_letters.deleted', '=', 0);

    }

    public function external_alerts() {
        return $this->hasMany('App\CompanyAlert')->orderBy('id', 'desc')->where('type', '=', 0);
    }
}
