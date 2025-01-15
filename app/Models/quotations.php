<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quotations extends Model
{
    use HasFactory;
    public function borrowers(){
        return $this->belongsTo(borrowers::class);
    }
    public function q_items(){
        return $this->belongsToMany(q_items::class);
    }
    public function q_delivery_orders(){
        return $this->hasOne(q_delivery_orders::class);
    }
    public function q_invoices(){
        return $this->hasOne(q_invoices::class);
    }
}
