<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SageTransaction extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $table = 'sagetransactions';

    protected $attributes = [
        'payment_method' => 1,
        'payment_type' => 0,
        'virtual_account_id' => 0,
        'booking_id' => 0,
        'weblead_id' => 0,
        'transaction_id' => 0,
        'profile_id' => 0,
        'VendorTxCode' => '',
        'VPSTxId' => 0,
        'Status' => 0,
        'StatusDetail' => '',
        'TxAuthNo' => '',
        'AVSCV2' => '',
        'AddressResult' => '',
        'PostCodeResult' => '',
        'CV2Result' => '',
        'GiftAid' => '',
        '3DSecureStatus' => '',
        'CardType' => '',
        'Last4Digits' => '',
        'DeclineCode' => '',
        'ExpiryDate' => '',
        'BankAuthCode' => '',
        'offline_notes' => '',
        'payment_status' => 2,
        'amount' => 0,
        'type' => 1
    ];

    public function order() {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function orders() {
        return $this->hasMany('App\Order', 'order_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function update_transactions($order_id =null, $payment_details = null,$type = null) {

        //print_r($payment_details);
        
        if(!empty($payment_details)){

            $saveData = [];
            
            $this->order_id = $order_id;
            $this->type = $payment_details->payment_type;
            
            
    		if($type == 'online'){
                
                $data = $payment_details->getData();

                //print_r($data);
                
                $this->transaction_id = $data['VPSTxId'];
	    		$this->payment_type = 1;
	    		$this->payment_method = 1;
	    		$this->payment_status = (strtolower($data['Status']) == 'ok') ? 2 : 0;
	    		$this->amount = str_replace(',','', $data['Amount']);

                $this->VendorTxCode = $data['VendorTxCode'];
                $this->VPSTxId = $data['VPSTxId'];
                $this->Status = $data['Status'];
                $this->StatusDetail = $data['StatusDetail'];
                $this->TxAuthNo = $data['TxAuthNo'];
                $this->AVSCV2 = $data['AVSCV2'];
                $this->AddressResult = $data['AddressResult'];
                $this->PostCodeResult = $data['PostCodeResult'];
                $this->CV2Result = $data['CV2Result'];
                $this->GiftAid = $data['GiftAid'];
                $this->{'3DSecureStatus'} = $data['3DSecureStatus'];
                $this->CardType = $data['CardType'];
                $this->Last4Digits = $data['Last4Digits'];
                //$this->DeclineCode = $data['DeclineCode'];
                $this->ExpiryDate = isset($data['ExpiryDate']) ? $data['ExpiryDate'] : '1225';
                $this->BankAuthCode = $data['BankAuthCode'];

    		} elseif ($type == 'offline'){
    			$this->payment_type = 0;
    			$this->offline_notes = $data['offline_notes'];
    			$this->payment_status = 2;
    			$this->amount = $data['amount'];
            }
            
            $this->save();
    		
            return $this;
            
    	} else {
    		return false;
    	}
    }

    public function update_invoice_transactions($id =null, $payment_details = null,$type = null) {

        //print_r($payment_details);
        
        if(!empty($payment_details)){

            $saveData = [];
            
            $this->invoice_id = $id;
            $this->type = $payment_details->payment_type;
            $this->order_id = 0;
            
    		if($type == 'online'){
                
                $data = $payment_details->getData();

                //print_r($data);
                
                $this->transaction_id = $data['VPSTxId'];
	    		$this->payment_type = 1;
	    		$this->payment_method = 1;
	    		$this->payment_status = (strtolower($data['Status']) == 'ok') ? 2 : 0;
	    		$this->amount = str_replace(',','', $data['Amount']);

                $this->VendorTxCode = $data['VendorTxCode'];
                $this->VPSTxId = $data['VPSTxId'];
                $this->Status = $data['Status'];
                $this->StatusDetail = $data['StatusDetail'];
                $this->TxAuthNo = $data['TxAuthNo'];
                $this->AVSCV2 = $data['AVSCV2'];
                $this->AddressResult = $data['AddressResult'];
                $this->PostCodeResult = $data['PostCodeResult'];
                $this->CV2Result = $data['CV2Result'];
                $this->GiftAid = $data['GiftAid'];
                $this->{'3DSecureStatus'} = $data['3DSecureStatus'];
                $this->CardType = $data['CardType'];
                $this->Last4Digits = $data['Last4Digits'];
                //$this->DeclineCode = $data['DeclineCode'];
                $this->ExpiryDate = isset($data['ExpiryDate']) ? $data['ExpiryDate'] : '1225';
                $this->BankAuthCode = $data['BankAuthCode'];

    		} elseif ($type == 'offline'){
    			
                $this->payment_type = 0;
    			$this->offline_notes = $data['offline_notes'];
    			$this->payment_status = 2;
    			$this->amount = $data['amount'];

            }
            
            $this->save();
    		
            return $this;
            
    	} else {

    		return false;

    	}
    }
}
