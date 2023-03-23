<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Product extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $table = 'products_v2';

    protected $attributes = [
        'mailbox_status' => 0,
        'scan_status' => 0,
        'scan_quantity' => 0,
        'pdf_url' => '',
        'active' => 1,
        'deleted' => 0,
        'v2' => 1
    ];

    public function order() {
        return $this->belongsTo('App\Order');
    }

    public function scan_products() {
        return $this->hasMany('App\ScanProduct', 'product_id');
    }

    public function forwarding_products() {
        return $this->hasMany('App\ForwardingProduct', 'product_id');
    }

    public function call_products() {
        return $this->hasMany('App\CallProduct', 'product_id');
    }

    public function voice_products() {
        return $this->hasMany('App\VoiceProduct', 'product_id');
    }

    public function products_203_207() {
        return $this->hasMany('App\Product203207', 'product_id');
    }

    public function _category() {
        return $this->belongsTo('App\ProductCategory', 'category');
    }

    public function product_extras() {
        return $this->hasMany('App\ProductExtra', 'product_id')
                ->select('product_extras.*','p2.name', 'p2.description as product_description', 'p2.name as product_name')
                ->join(DB::raw('products_v2 p2'), 'p2.id','=','product_extras.extra_product_id')
                ->orderBy(DB::Raw('CONCAT(p2.name, " ", p2.term)'), 'asc')
                ->whereRaw('p2.available_for_purchase = 1');
    }

    public function included() {
        return $this->hasMany('App\ProductExtra', 'product_id')
                ->select('product_extras.*','p2.name')
                ->where('product_extras.included', '=', 1)
                ->where('product_extras.optional', '=', 0)
                ->join(DB::raw('products_v2 p2'), 'p2.id','=','product_extras.extra_product_id')
                ->orderBy(DB::Raw('CONCAT(p2.name, " ", p2.term)'), 'asc');
    }

    public function optionals() {
        return $this->hasMany('App\ProductExtra', 'product_id')
                ->select('product_extras.*','p2.name','p2.category', DB::raw('product_categories.name as category_name'))
                ->where('product_extras.optional', '=', 0)
                ->where('product_extras.included', '=', 0)
                ->where('product_extras.price', '>', 0)
                ->join(DB::raw('products_v2 p2'), 'p2.id','=','product_extras.extra_product_id')
                ->join('product_categories', 'product_categories.id','=', 'p2.category')
                ->orderBy(DB::Raw('CONCAT(p2.name, " ", p2.term)'), 'asc');
    }

    public function free_optionals() {
        return $this->hasMany('App\ProductExtra', 'product_id')
                ->select('product_extras.*','p2.name','p2.category')
                ->where('product_extras.optional', 1)
                ->where('product_extras.price', '=', 0)
                ->join(DB::raw('products_v2 p2'), 'p2.id','=','product_extras.extra_product_id')
                ->orderBy(DB::Raw('CONCAT(p2.name, " ", p2.term)'), 'asc');
    }
    

    public function term_1_product() {

        return $this->belongsTo('App\Product', 'term_1');

    }    

    public function term_6_product() {

        return $this->belongsTo('App\Product', 'term_6');

    }

    public function term_3_product() {

        return $this->belongsTo('App\Product', 'term_3');

    }

    public function term_12_product() {

        return $this->belongsTo('App\Product', 'term_12');

    }
}
