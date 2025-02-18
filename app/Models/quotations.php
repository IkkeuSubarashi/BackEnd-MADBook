<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class quotations extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'logo',
        'subject',
        'address',
        'email',
        'c_name',
        'c_no',
        'c_address',
        'issue_date',
        'valid_date',
        'notes',
        'status',
        'q_total',
        'notes',
        'borrower_id',
    ];

    public function borrower()
    {
        return $this->belongsTo(borrower::class, 'borrower_id');
    }
    public function q_items()
    {
        return $this->belongsToMany(q_items::class, 'quote_items', 'quote_id', 'item_id');
    }
    public function q_delivery_orders()
    {
        return $this->hasOne(q_delivery_orders::class, 'quote_id');
    }
    public function q_invoices()
    {
        return $this->hasOne(q_invoices::class, 'quote_id');
    }
    public function calculateQTotal()
    {
        return $this->q_items()->sum(DB::raw('price * quantity'));
    }
}
