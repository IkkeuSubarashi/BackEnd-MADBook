<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\quotations;
use App\Models\q_items;

class q_item extends Seeder
{
    public function run(): void
    {
        $item = quotations::all();

        foreach($item as $id){
            for($i=0; $i<10; $i++){
                $qtems = q_items::create([
                    'description' => Str::random(10),
                    'qty' => random_int(1,50),
                    'unit_price' => 3.142,
                ]);
                $id->q_items()->attach($qtems->id);
            }
        }
    }
}
