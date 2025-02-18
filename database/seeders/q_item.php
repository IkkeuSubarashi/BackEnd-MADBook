<?php

namespace Database\Seeders;

use App\Models\q_delivery_orders;
use App\Models\q_invoices;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\quotations;
use App\Models\q_items;
use Illuminate\Support\Facades\DB;

class q_item extends Seeder
{
    public function run(): void
    {
        $quotations = quotations::all();

        if ($quotations->isEmpty()) {
            \Log::error('No quotations found in the database.');
            return;
        }

        foreach ($quotations as $quote) {
            $q_total = 0;

            for ($i = 0; $i < 5; $i++) {

                $quantity = random_int(1, 10);
                $price = round(mt_rand(10, 100) / 10, 2);
                $total = $quantity * $price;

                $qItem = q_items::create([
                    'name' => fake()->word(),
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $total,
                ]);


                if (!$qItem) {
                    \Log::error('Failed to create q_item for quote ID: ' . $quote->id);
                    continue;
                }

                DB::table('quote_items')->insert([
                    'quote_id' => $quote->id,
                    'item_id' => $qItem->id,
                ]);

                $q_total += $total;

                \Log::info('q_item created for quote ID: ' . $quote->id);
            }

            $quote->update(['q_total' => $q_total]);

            $invoice = q_invoices::inRandomOrder()->first();
            $deliveryOrder = q_delivery_orders::inRandomOrder()->first();

            if (!$invoice) {
                \Log::error('No invoices found for quote ID: ' . $quote->id);
                continue;
            }

            if (!$deliveryOrder) {
                \Log::warning('No delivery orders found for quote ID: ' . $quote->id);
                continue;
            }

            foreach ($quote->q_items as $qItem) {
                $qItem->update([
                    'invoice_id' => $invoice->id, // Kaitkan dengan invois yang sudah ada
                    'delivery_order_id' => $deliveryOrder->id, // Kaitkan dengan delivery order yang sudah ada
                ]);

                // Masukkan ke dalam jadual penghubung (pivot table)
                DB::table('invoice_items')->insert([
                    'invoice_id' => $invoice->id,
                    'item_id' => $qItem->id,
                ]);

                DB::table('do_items')->insert([
                    'delivery_order_id' => $deliveryOrder->id,
                    'item_id' => $qItem->id,
                ]);
            }
        }
    }
}
