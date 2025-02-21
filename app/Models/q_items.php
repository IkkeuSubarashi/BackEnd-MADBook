<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class q_items extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'price',
        'quantity',
        'total',
    ];

    public function quotations()
    {
        return $this->belongsToMany(quotations::class, 'quote_items', 'item_id', 'quote_id');
    }
    public function q_delivery_order()
    {
        return $this->belongsToMany(q_delivery_orders::class, 'do_items', 'item_id', 'delivery_order_id');
    }
    public function q_invoice()
    {
        return $this->belongsToMany(q_invoices::class, 'invoice_items', 'item_id', 'invoice_id');
    }
}
