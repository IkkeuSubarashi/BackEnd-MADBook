<?php

namespace App\Models;

use Database\Seeders\q_invoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class borrower extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function quotations(){
        return $this->hasMany(quotations::class,'borrower_id');
    }

    public function q_invoices(){
        return $this->hasManyThrough(q_invoices::class, quotations::class, 'borrower_id', 'quote_id');
    }
}
