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
        'i_total',
        'issue_date',
    ];

    public function q_delivery_orders()
    {
        return $this->belongsTo(q_delivery_orders::class, 'delivery_order_id');
    }
    public function quotations()
    {
        return $this->belongsTo(quotations::class, 'quote_id');
    }
    public function q_bank_details()
    {
        return $this->hasOne(BankDetails::class, 'delivery_order_id');
    }
    public function q_items()
    {
        return $this->belongsToMany(q_items::class, 'invoice_items', 'invoice_id', 'item_id');
    }
}
