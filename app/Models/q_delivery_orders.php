<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class q_delivery_orders extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'quote_id',
        'created_at',
        'delivery_date',
        'due_date',
        'partner_by',
        'partner_cost',
    ];

    public function quotations(){
        return $this->belongsTo(quotations::class,'quote_id');
    }
    public function q_invoices(){
        return $this->hasOne(q_invoices::class,'delivery_order_id');
    }
}
