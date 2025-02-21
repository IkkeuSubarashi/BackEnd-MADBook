<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\quotations;
use App\Models\q_delivery_orders;
use App\Models\q_invoices;
use DB;

class q_invoice extends Seeder
{
    public function run(): void
    {
        $quotes = quotations::where('status', true)
            ->with('q_delivery_orders')
            ->get();


        foreach ($quotes as $quote) {
            $delivery_order = $quote->q_delivery_orders;

            if ($delivery_order) {
                $invoice = q_invoices::create([
                    'delivery_order_id' => $delivery_order->id,
                    'quote_id' => $quote->id,
                    'status' => 'Pending',
                    'i_total' => $delivery_order->do_total,
                    'issue_date' => now(),
                ]);

                foreach ($quote->q_items as $item) {
                    DB::table('invoice_items')->insert([
                        'invoice_id' => $invoice->id,
                        'item_id' => $item->id,
                    ]);
                }
            }
        }
    }
}
