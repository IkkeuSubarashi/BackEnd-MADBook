<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class q_invoices extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'delivery_order_id',
        'quote_id',
        'status',
        'total',
        'created_at',
    ];

    public function q_delivery_orders(){
        return $this->belongsTo(q_delivery_orders::class,'delivery_order_id');
    }
    public function quotations(){
        return $this->belongsTo(quotations::class,'quote_id');
    }
}
