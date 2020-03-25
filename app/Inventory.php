<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'item',
        'description',
        'price',
        'quantity_at_hand'
    ];

    public function orders() {
        return $this->hasMany('App\OrderDetail');
    }
}
