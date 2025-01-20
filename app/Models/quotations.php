<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quotations extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'logo',
        'subject',
        'valid_date',
        'status',
        'total',
        'created_at',
        'c_name',
        'c_address',
        'c_no',
        'borrower_id',
    ];

    public function borrowers(){
        return $this->belongsTo(borrower::class,'borrower_id');
    }
    public function q_items(){
        return $this->belongsToMany(q_items::class,'quote_items','quote_id','item_id');
    }
    public function q_delivery_orders(){
        return $this->hasOne(q_delivery_orders::class,'quote_id');
    }
    public function q_invoices(){
        return $this->hasOne(q_invoices::class,'quote_id');
    }
}
