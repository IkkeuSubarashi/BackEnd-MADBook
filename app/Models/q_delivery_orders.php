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
        'issue_date',
        'delivery_date',
        'due_date',
        'ship_by',
        'ship_fee',
        'bank_name',
        'acc_holder',
        'acc_num',
        'c_name',
        'c_no',
        'c_address',
        'do_total',
        'notes'
    ];

    public function quotations()
    {
        return $this->belongsTo(quotations::class, 'quote_id');
    }
    public function q_invoices()
    {
        return $this->hasOne(q_invoices::class, 'delivery_order_id');
    }
    public function q_bank_details()
    {
        return $this->hasOne(BankDetails::class, 'delivery_order_id', 'id');
    }
    public function q_items()
    {
        return $this->belongsToMany(q_items::class, 'do_items', 'delivery_order_id', 'item_id');
    }
    public function calculateDoTotal()
    {
        $quote = $this->quotations;
        return $quote->q_total + $this->ship_fee;
    }
}
