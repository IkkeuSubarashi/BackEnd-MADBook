<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class borrower extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function quotations(){
        return $this->hasMany(quotations::class);
    }
}
