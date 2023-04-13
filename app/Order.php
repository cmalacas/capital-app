<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

use App\CompanyHouseData;

use Carbon\Carbon;

class Order extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $attributes = [
        'deleted' => 0,
        'product_contract_length' => 0,
        'contract_length' => 0,
        'recurring_type' =>  0,
        'discount_type' => 0,
        'no_of_months' => 0,
        'discount_percentage' => 0,
        'coupon_id' => 0,
        'coupon_percentage' => 0,
        'notes' => '',
        'total_discount_amount' => 0,
        'vat' => 0,
        'order_status' => 0,
        'update_status' => 0,
        'reminder_sent' => '1970-01-01',
        'contract_startdate' => '1970-01-01 00:00:00',
        'contract_enddate' => '1970-01-01 00:00:00',
        'contract_paypaldate' => '1970-01-01 00:00:00',
		'last_email_sent' => '1970-01-01 00:00:00',
		'order_type' => 0,
		'weblead_id' => 0,
		'type' => 0,
        'user_id' => 1
    ];

    public function product() {
        return $this->belongsTo('App\Product');
    }

    public function client() {
        return $this->belongsTo('App\Client');
    }

    public function company() {
        return $this->belongsTo('App\Company');
    }

    public function user() {
        return $this->belongsTo('App\User')->where(DB::raw('new_users.active'), '=', 1);
    }

    public function coupon() {
        return $this->belongsTo('App\Coupon', 'coupon_id');
    }

    public function transactions() {
        return $this->hasMany('App\Transaction', 'order_id')->orderBy('created', 'desc');
	}
	
	public function package_transactions() {
        return $this->hasMany('App\SageTransaction', 'order_id', 'package_order_id');
    }

    public function sagetransactions() {
        return $this->hasMany('App\SageTransaction', 'order_id')->orderBy('created', 'desc');
    }

		public function companies() {

			return $this->hasMany('App\Company', 'company_id');

		}

    public function create_pdf_body() {
		
		if(empty($this->product->recurring_type)){
			$type = "One Time";
		}else{
			$type = "Recurring";
        }
        
        $productName = empty($this->order_type) ? $this->product->name : $this->product_name;
        
        $productAmt = '£'.number_format($this->amount, 2, '.', '');
        
        $discountlAmt = '£'.number_format($this->total_discount_amount, 2, '.', '');
        
        $vat = number_format($this->vat, 2, '.', '').'%';
        
		$totalAmt = '£'.number_format($this->total_amount, 2, '.', '');

        $fullname = ucwords($this->client->first_name).' '.ucwords($this->client->last_name);
        
        $addr_arr = array();
        
		if($this->client->address)
			$addr_arr[] = ucwords($this->client->address);
        
        if($this->client->city)
			$addr_arr[] = ucwords($this->client->city);        
            
        if($this->client->post_code)
			$addr_arr[] = ucwords($this->client->post_code);
        
        if($this->client->country)
			$addr_arr[] = ucwords($this->client->country);
        
        $full_address = implode(", ", $addr_arr);
		
		$message =	'<style type="text/css">
						a:link,a:visited {color: #C95900;}
        				a:hover {text-decoration: none;}
        				table {font-family: arial, sans-serif;border-collapse: collapse;}
        				td,th {border: 1px solid #dddddd;text-align: left;padding: 14px;}
        				tr:nth-child(even) {background-color: #efefef;}</style>';
		$message .=	 	'<div>';
		$message .=			'<table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; border-collapse: collapse;border-spacing: 0;width: 100%;padding-top:0px;">';
		$message .=				'<tr width="100%">';
		$message .=					'<td colspan="2" style="color: #0096CB;" width="100%">';
		$message .=						'<table border="0" cellpadding="2" cellspacing="2" style="font-size: 37px;color:black;">';
										if($fullname){
											$message .=				'<tr>';
											$message .=					'<td style="font-family:Arial Black, Gadget, sans-serif;font-weight: bold;font-size: 35px;">Customer Name</td>';
											$message .=					'<td>'.$fullname.'</td>';
											$message .=					'<td style="font-family:Arial Black, Gadget, sans-serif;font-weight: bold;font-size: 35px;">Address</td>';
											$message .=					'<td>'.$full_address.'</td>';
											$message .=				'</tr>';
										}
		$message .=							'<tr>';
		$message .=								'<td style="font-family:Arial Black, Gadget, sans-serif;font-weight: bold;font-size: 35px;">Order ID</td>';
		$message .=								'<td>CPOO'.$this->id.'</td>';
        
        if(!empty($this->transactions[0]['payment_type'])){
			$message .=								'<td style="font-family:Arial Black, Gadget, sans-serif;font-weight: bold;font-size: 35px;">Transaction ID</td>';
			$message .=								'<td>'.$this->transactions[0]->transaction_id.'</td>';
		}else{
			$message .=								'<td style="font-family:Arial Black, Gadget, sans-serif;font-weight: bold;font-size: 35px;">Payment Type</td>';
			$message .=								'<td>Offline</td>';
		}
        
        $message .=							'</tr>';
		$message .=							'<tr>';
		$message .=								'<td style="font-family:Arial Black, Gadget, sans-serif;font-weight: bold;font-size: 35px;">Company Name</td>';
		$message .=								'<td>'.$this->company->name.'</td>';
		$message .=								'<td style="font-family:Arial Black, Gadget, sans-serif;font-weight: bold;font-size: 35px;">Order Date</td>';
		$message .=								'<td>'.date('d-M-Y',strtotime($this->order_date)).'</td>';
		$message .=							'</tr>';
		$message .=							'<tr>';
		$message .=								'<td style="font-family:Arial Black, Gadget, sans-serif;font-weight: bold;font-size: 35px;">Product Name</td>';
		$message .=								'<td>'.$productName.'</td>';
		$message .=								'<td style="font-family:Arial Black, Gadget, sans-serif;font-weight: bold;font-size: 35px;">Product Amount</td>';
		$message .=								'<td>'.$productAmt.'</td>';
		$message .=							'</tr>';
		$message .=							'<tr>';
		$message .=								'<td style="font-family:Arial Black, Gadget, sans-serif;font-weight: bold;font-size: 35px;">Pricing Type</td>';
		$message .=								'<td>'.$type.'</td>';
		$message .=								'<td style="font-family:Arial Black, Gadget, sans-serif;font-weight: bold;font-size: 35px;">Total Discount Amount</td>';
		$message .=								'<td>'.$discountlAmt.'</td>';
		$message .=							'</tr>';
        
        if(!empty($this->recurring_type)){
			$message .=							'<tr>';
			$message .=								'<td style="font-family:Arial Black, Gadget, sans-serif;font-weight: bold;font-size: 35px;">Contract Start Date</td>';
			$message .=								'<td>'.date('d-M-Y',strtotime($this->contract_startdate)).'</td>';
			$message .=								'<td style="font-family:Arial Black, Gadget, sans-serif;font-weight: bold;font-size: 35px;">VAT</td>';
			$message .=								'<td>'.$vat.'</td>';
			$message .=							'</tr>';
			$message .=							'<tr>';
			$message .=								'<td style="font-family:Arial Black, Gadget, sans-serif;font-weight: bold;font-size: 35px;">Contract End Date</td>';
			$message .=								'<td>'.date('d-M-Y',strtotime($this->contract_enddate)).'</td>';
			$message .=								'<td style="font-family:Arial Black, Gadget, sans-serif;font-weight: bold;font-size: 35px;">Total Amount</td>';
			$message .=								'<td>'.$totalAmt.'</td>';
			$message .=							'</tr>';
		}else{
			$message .=							'<tr>';
			$message .=								'<td colspan="2"></td>';
			$message .=								'<td style="font-family:Arial Black, Gadget, sans-serif;font-weight: bold;font-size: 35px;">VAT</td>';
			$message .=								'<td>'.$vat.'</td>';
			$message .=							'</tr>';
			$message .=							'<tr>';
			$message .=								'<td colspan="2"></td>';
			$message .=								'<td style="font-family:Arial Black, Gadget, sans-serif;font-weight: bold;font-size: 35px;">Total Amount</td>';
			$message .=								'<td>'.$totalAmt.'</td>';
			$message .=							'</tr>';
		}
		$message .=						'</table>';
		$message .=						'</td>';
		$message .=					'</tr>';
		$message .=			'</table>';
		$message .=		'</div>';
		
		$message .=		'<div>';
		$message .=			'<span>Capital Office Ltd</span><br>';
		$message .=			'<span>Registered Office Address: 124 City Road, London EC1V 2NX</span><br>';
		$message .=			'<span>Registered in England & Wales Company Number 06294297</span><br>';
		$message .=			'<span>VAT Registration Number: 976201416</span>';
		$message .=		'</div>';
		
		return $message;
	}

	public function extras() {
		return $this->hasMany('App\Order', 'package_order_id')
									->select(
										'orders.*',
										DB::raw('companies.name as company_name'),
										DB::raw('products_v2.term as product_term')
									)							
								->join('companies', 'companies.id', '=', 'company_id')
								->join('products_v2', 'products_v2.id', '=', 'product_id')
								->where('products_v2.recurring_type', '=', 1);
	}

	public function groups() {
		return $this->hasMany('App\Order', 'group_order_id')
									->select(
										'orders.*',
										DB::raw('companies.name as company_name'),
										DB::raw('products_v2.term as product_term')
									)							
								->join('companies', 'companies.id', '=', 'company_id')
								->join('products_v2', 'products_v2.id', '=', 'product_id');								
	}

	public function amlc_notes() {
		return $this->hasMany('App\OrderAmlcNote', 'order_id')
							->select('order_amlc_notes.*', 
									     DB::raw('CONCAT(first_name, " ", last_name) AS created_by'),
											 DB::raw('DATE_FORMAT(order_amlc_notes.created_at, "%d %M %Y %h:%i") as date')
										)
							->join('new_users', 'new_users.id', '=', 'created_by')
							->orderBy('order_amlc_notes.created_at');
	}

	public function virtual_account() {
		return $this->hasOne('App\VirtualAccount', 'order_id');
	}

	public function virtual_scan_account() {
		return $this->hasOne('App\VirtualScanAccount', 'order_id');
	}

	public function change_logs() {

		return $this->hasMany('App\ChangeLog', 'table_id')
								->where('table_name', '=', 'Orders');

	}

	public function links() {

		return $this->hasMany('App\OrderLink', 'order_id');

	}

	public function included() {

		return $this->hasMany('App\Order', 'package_order_id')
							->select(
									'orders.*',
									DB::raw('companies.name as company_name'),
									DB::raw('products_v2.term as product_term')
								)							
							->join('companies', 'companies.id', '=', 'company_id')
							->join('products_v2', 'products_v2.id', '=', 'product_id')
							->where('orders.deleted', '=', 0)
							->where('products_v2.recurring_type', '=', 1);

	}

	static function getExpiredNextWeekData() {

		$nextWeekDate = Carbon::parse('next monday');

		$orders = Order::select('orders.*')
                    ->orderBy('orders.contract_enddate', 'desc')
                    ->where(DB::raw('DATE(contract_enddate)'), '>=', $nextWeekDate->startOfWeek()->format("Y-m-d"))
										->where(DB::raw('DATE(contract_enddate)'), '<=', $nextWeekDate->endOfWeek()->format("Y-m-d"))
										->whereIn(DB::raw('orders.type'), [0])
										->join('products_v2', 'product_id', '=', 'products_v2.id')
										->join('clients', 'clients.id', '=', 'client_id')
										->join('companies', 'companies.id', '=', 'company_id')
                    ->whereRaw('products_v2.type in (0,2,3)')
                    ->groupBy(DB::raw('orders.company_id'))
										->where(DB::raw('companies.deleted'), '=', 0)
										->where(DB::raw('clients.deleted'), '=', 0)
										->where(DB::raw('orders.deleted'), '=', 0)
                    ->get();
		
		return $orders;

	}

	static function getExpiredThisWeekData() {

		$orders = Order::select('orders.*')
                    ->orderBy('orders.contract_enddate', 'desc')
                    ->whereRaw('products_v2.type in (0,2,3)')
                    ->where(DB::raw('DATE(contract_enddate)'), '>=', Carbon::now()->startOfWeek()->format("Y-m-d"))
                    ->where(DB::raw('DATE(contract_enddate)'), '<=', Carbon::now()->endOfWeek()->format("Y-m-d"))
                    ->whereIn(DB::raw('orders.type'), [0])
							      ->join('products_v2', 'product_id', '=', 'products_v2.id')
										->join('clients', 'clients.id', '=', 'client_id')
										->join('companies', 'companies.id', '=', 'company_id')
                    ->whereRaw('products_v2.type in (0,2,3)')
                    ->groupBy(DB::raw('orders.company_id'))
										->where(DB::raw('companies.deleted'), '=', 0)
										->where(DB::raw('clients.deleted'), '=', 0)
										->where(DB::raw('orders.deleted'), '=', 0)
                    ->get();

		$orders = $orders->filter(function($row, $key) use ( $chData ) {

										$renewed = Order::where('client_id', '=',$row->client_id)
																->where('product_id', '=', $row->product_id)
																->where('company_id', '=', $row->company_id)
																->whereRaw('contract_enddate >= NOW()')
																->first();

										return !$renewed;

								})->values();

		return $orders;

	}

	static function getExpiredLastWeekData() {

		ini_set('max_execution_time', 300);

		$lastWeekDate = Carbon::now()->subDays(Carbon::now()->dayOfWeek + 1);

		$orders = Order::select(
												DB::raw('orders.id'),
												DB::raw('orders.client_id'),
												DB::raw('orders.product_id'),
												DB::raw('orders.company_id'),
												DB::raw('orders.product_name'),
												DB::raw('orders.contract_enddate'),
												DB::raw('clients.first_name as client_first_name'),
												DB::raw('clients.last_name as client_last_name'),
												DB::raw('clients.industry as client_industry'),
												DB::raw('companies.name as company_name'),
												DB::raw('companies.t_mailbox_number as company_mailbox_number')
											)
                    ->orderBy('orders.contract_enddate', 'desc')
                    ->whereRaw('products_v2.type in (0,2,3)')
                    ->where(DB::raw('DATE(contract_enddate)'), '>=', $lastWeekDate->startOfWeek()->format("Y-m-d"))
                    ->where(DB::raw('DATE(contract_enddate)'), '<=', $lastWeekDate->endOfWeek()->format("Y-m-d"))
                    ->whereIn(DB::raw('orders.type'), [0])
							      ->join('products_v2', 'product_id', '=', 'products_v2.id')
										->join('clients', 'clients.id', '=', 'client_id')
										->join('companies', 'companies.id', '=', 'company_id')
										->join('company_house_data', DB::raw('CompanyName'), '=', DB::raw('companies.name'))
                    ->whereRaw('products_v2.type in (0,2,3)')
                    ->groupBy(DB::raw('orders.company_id'))
										->where(DB::raw('companies.deleted'), '=', 0)
										->where(DB::raw('clients.deleted'), '=', 0)
										->where(DB::raw('orders.deleted'), '=', 0)
										->whereRaw('( SELECT COUNT(*) FROM orders o WHERE o.client_id = orders.client_id AND o.company_id = orders.company_id AND DATE(o.contract_enddate) > NOW() ) = 0')
										->get();

		
		return $orders;

	}

	static function getExpiredThisMonthData() {

		$orders = Order::select('orders.*')
                    ->orderBy('orders.contract_enddate', 'desc')
                    ->whereRaw('products_v2.type in (0,2,3)')
                    ->where(DB::raw('DATE(contract_enddate)'), '>=', date("Y-m-d", mktime(0,0,0, date("m"), 1, date("Y"))))
                    ->where(DB::raw('DATE(contract_enddate)'), '<=', date("Y-m-d", mktime(0,0,0, date("m"), date("t"), date("Y"))))
                    ->whereIn(DB::raw('orders.type'), [0])
										->join('products_v2', 'product_id', '=', 'products_v2.id')
										->join('clients', 'clients.id', '=', 'client_id')
										->join('companies', 'companies.id', '=', 'company_id')
                    ->whereRaw('products_v2.type in (0,2,3)')
                    ->groupBy(DB::raw('orders.company_id'))
										->where(DB::raw('companies.deleted'), '=', 0)
										->where(DB::raw('clients.deleted'), '=', 0)
										->where(DB::raw('orders.deleted'), '=', 0)
                    ->get();

		$orders = $orders->filter(function($row, $key) {

										$renewed = Order::where('client_id', '=',$row->client_id)
																->where('company_id', '=', $row->company_id)
																->whereRaw('contract_enddate >= NOW()')
																->first();

										return !$renewed;

								})->values();

		return $orders;

	}

	static function getExpiredLastMonthData() {

		ini_set('max_execution_time', 300);

		$month = date("m") - 1;
		$day = date("t", mktime(0,0,0, $month, 1, date("Y")));

		$orders = Order::select(
												DB::raw('orders.id'),
												DB::raw('orders.client_id'),
												DB::raw('orders.product_id'),
												DB::raw('orders.company_id'),
												DB::raw('orders.product_name'),
												DB::raw('orders.contract_enddate'),
												DB::raw('clients.first_name as client_first_name'),
												DB::raw('clients.last_name as client_last_name'),
												DB::raw('clients.industry as client_industry'),
												DB::raw('companies.name as company_name'),
												DB::raw('companies.t_mailbox_number as company_mailbox_number')
											)
                    ->orderBy('orders.contract_enddate', 'desc')
                    ->whereRaw('products_v2.type in (0,2,3)')
                    ->where(DB::raw('DATE(contract_enddate)'), '>=', date("Y-m-d", mktime(0,0,0, $month, 1, date("Y"))))
                    ->where(DB::raw('DATE(contract_enddate)'), '<=', date("Y-m-d", mktime(0,0,0, $month, $day, date("Y"))))
                    ->whereIn(DB::raw('orders.type'), [0])
										->join('products_v2', 'product_id', '=', 'products_v2.id')
										->join('clients', 'clients.id', '=', 'client_id')
										->join('companies', 'companies.id', '=', 'company_id')
										->join('company_house_data', 'CompanyName', '=', DB::raw('companies.name'))
                    ->whereRaw('products_v2.type in (0,2,3)')
                    ->groupBy(DB::raw('orders.company_id'))
										->where(DB::raw('companies.deleted'), '=', 0)
										->where(DB::raw('clients.deleted'), '=', 0)
										->where(DB::raw('orders.deleted'), '=', 0)
										->whereRaw('( SELECT COUNT(*) FROM orders o WHERE o.client_id = orders.client_id AND o.company_id = orders.company_id AND DATE(o.contract_enddate) > NOW() ) = 0')
										->get();

		return $orders;

	}

	static function getExpiredData() {

		$dates = [];

		$daysBefore = [1, 2, 7, 14, 28];

		$daysAfter = [1, 5];

		$now = Carbon::now();

		foreach( $daysBefore as $d ) {

				$dates[] = Carbon::now()->addDays( $d )->format("Y-m-d");

		}

		foreach( $daysAfter as $d ) {

				$dates[] = Carbon::now()->subDays( $d )->format("Y-m-d");

		}

		$from = $now->subDays(15)->format('Y-m-d');

		$orders = Order::select('orders.*')
								->orderBy('orders.contract_enddate', 'desc')
								->join('products_v2', 'product_id', '=', 'products_v2.id')
								->whereRaw('products_v2.type in (0,2,3)')
								->whereIn(DB::raw('orders.contract_enddate'), $dates)
								->join('clients', 'clients.id', '=', 'client_id')
								->join('companies', 'companies.id', '=', 'company_id')
								->whereRaw('products_v2.type in (0,2,3)')
								->groupBy(DB::raw('orders.company_id'))
			->where(DB::raw('companies.deleted'), '=', 0)
			->where(DB::raw('clients.deleted'), '=', 0)
			->where(DB::raw('orders.deleted'), '=', 0)
								->get();

		$chData = CompanyHouseData::_get();

		$orders = $orders->filter(function($row, $key) use ($chData) {

										$ch = $chData->filter( function( $chRow, $key ) use ( $row )  {

											$company_name = $row->company->name;

											return strpos( strtolower($chRow->CompanyName), strtolower($company_name) ) >= 0;

										});
										
										$renewed = Order::where('client_id', '=',$row->client_id)
																->where('product_id', '=', $row->product_id)
																->where('company_id', '=', $row->company_id)
																->whereRaw('contract_enddate >= NOW()')
																->first();

										return $ch->count() > 0 && !$renewed;

								})->values();

			return $orders;
	}

	static function getAllExpired() {

		ini_set('max_execution_time', 300);

		$results = Order::select(
												DB::raw('orders.id'),
												'product_id',
												DB::raw('orders.client_id'),
												'company_id',
												DB::raw('DATE(contract_enddate) AS contract_enddate'),
												DB::raw('products_v2.name as product_name'),
												DB::raw('CONCAT(clients.first_name, " ", clients.last_name) as client_name'),
												DB::raw('companies.name as company_name')
										)
								->whereRaw('DATE(contract_enddate) < NOW()')
								->whereIn(DB::raw('orders.type'), [0])
								->whereIn(DB::raw('orders.type'), [0])
								->join('products_v2', 'product_id', '=', 'products_v2.id')
								->join('clients', 'clients.id', '=', 'client_id')
								->join('companies', 'companies.id', '=', 'company_id')
								->whereRaw('CompanyHouseName IN ( SELECT CompanyNameAlias FROM company_house_data)')
								->whereRaw('products_v2.type in (0,2,3)')
								->groupBy(DB::raw('orders.company_id'))
								->where(DB::raw('companies.deleted'), '=', 0)
								->where(DB::raw('clients.deleted'), '=', 0)
								->where(DB::raw('orders.deleted'), '=', 0)
								->whereRaw('( SELECT COUNT(*) FROM orders o WHERE o.client_id = orders.client_id AND o.company_id = orders.company_id AND DATE(o.contract_enddate) > NOW() ) = 0')
								->orderBy(DB::raw('orders.contract_enddate'), 'desc')
								->get();
			
		return $results;

	}

}
