<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class q_invoices extends Model
{
    use HasFactory;

    public function q_delivery_orders(){
        return $this->belongsTo(q_delivery_orders::class);
    }
    public function quotations(){
        return $this->belongsTo(quotations::class);
    }
}
