<?php

namespace Database\Seeders;

use App\Models\BankDetails;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\quotations;
use App\Models\q_delivery_orders;
use DB;

class deliveryOrder extends Seeder
{
    public function run(): void
    {
        $quotes = quotations::with('q_items')
            ->where('status', true)
            ->get();

        foreach ($quotes as $quote) {
            $qdo = q_delivery_orders::create([
                'quote_id' => $quote->id,
                'issue_date' => now()->toDateString(),
                'delivery_date' => now()->addDays(5)->toDateString(),
                'due_date' => now()->addDays(4)->toDateString(),
                'ship_by' => 'Ninjavan',
                'ship_fee' => 10.00,
                'c_name' => $quote->c_name,
                'c_no' => $quote->c_no,
                'c_address' => $quote->c_address,
                'do_total' => 0,
                'notes' => "Please do your payment before due date.",
            ]);

            $qdo->update(['do_total' => $qdo->calculateDoTotal()]);

            if ($quote->q_items->isNotEmpty()) {
                foreach ($quote->q_items as $item) {
                    DB::table('do_items')->insert([
                        'delivery_order_id' => $qdo->id,
                        'item_id' => $item->id,
                    ]);
                }
            } else {
                \Log::warning("No items found for quote ID: {$quote->id}");
            }

            BankDetails::create([
                'delivery_order_id' => $qdo->id,
                'bank_name' => 'Maybank Malaysia',
                'acc_holder' => 'John Doe',
                'acc_num' => '1234567890',
            ]);
        }
    }
}
