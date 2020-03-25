<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'order_date',
        'order_notes'
    ];

    public function customer(){
        return $this->belongsTo('App\Customer');
    }

    public function details(){
        return $this->hasMany('App\OrderDetail');
    }
}
