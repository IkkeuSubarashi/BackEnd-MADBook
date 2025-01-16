<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class q_delivery_orders extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function quotations(){
        return $this->belongsTo(quotations::class,'quote_id');
    }
    public function q_invoices(){
        return $this->hasOne(q_invoices::class,'delivery_order_id');
    }
}
