<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\quotations;
use App\Models\q_delivery_orders;

class deliveryOrder extends Seeder
{
    public function run(): void
    {
        $quotes = quotations::where('status', true)
                ->get();

        foreach($quotes as $quote){
            q_delivery_orders::create([
                'quote_id' => $quote->id,
                'created_at' => '2025-1-15',
                'delivery_date' => '2025-1-15',
                'due_date' => '2025-1-15',
                'partner_by' => 'Turtle-Van',
                'partner_cost' => 3.142,
            ]);
        }
    }
}
