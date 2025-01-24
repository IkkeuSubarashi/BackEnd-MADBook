<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class q_items extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'description',
        'qty',
        'unit_price',
    ];
    
    public function quotations(){
        return $this->belongsToMany(quotations::class,'quote_items','item_id','quote_id');
    }
}
