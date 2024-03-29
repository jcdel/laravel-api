<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'inventory_id',
        'quantity'
    ];

    public function orders(){
        return $this->belongsTo('App\Order');
    }
}
