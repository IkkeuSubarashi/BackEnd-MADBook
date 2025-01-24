<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\quotations;
use App\Models\q_delivery_orders;
use App\Models\q_invoices;

class q_invoice extends Seeder
{
    public function run(): void
    {
        $quotes = quotations::with([
            'q_delivery_orders'
        ])->where('status', true)
          ->get();


        foreach($quotes as $quote){
            q_invoices::create([
                'delivery_order_id' => $quote->q_delivery_orders->id,
                'quote_id' => $quote->id,
                'status' => 'pending',
                'total' => 3.142,
                'created_at' => '2025-1-15',
            ]);
        }
    }
}
