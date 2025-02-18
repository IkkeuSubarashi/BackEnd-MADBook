<?php

namespace App\Models;

use App\Http\Controllers\api\MADBookInvoice;
use App\Http\Controllers\QInvoicesController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetails extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'q_bank_details';

    protected $fillable = [
        'delivery_order_id',
        'bank_name',
        'acc_holder',
        'acc_num',
    ];

    public function q_invoice()
    {
        return $this->belongsTo(q_invoices::class, 'delivery_order_id', 'id');
    }
    public function q_delivery_order()
    {
        return $this->belongsTo(q_delivery_orders::class, 'delivery_order_id');
    }
}
