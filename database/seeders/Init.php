<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\borrower;
use App\Models\quotations;
use Illuminate\Support\Facades\DB;
use App\Models\q_item;
use App\Models\q_items;

class Init extends Seeder
{
    public function run(): void
    {
        $borrower = [];

        for ($i = 1; $i <= 10; $i++) {
            $borrower[] = borrower::create([
                'email' => "borrower$i@example.com",
                'name' => "Borrower $i",
                'address' => "Street $i, Business Valley, City, State",
            ]);
        }

        foreach ($borrower as $id) {
            if ($id->id == 1) {
                continue;
            }

            for ($ii = 1; $ii <= 5; $ii++) {
                // Fetch 3 random items from q_items table
                $items = q_items::inRandomOrder()->limit(3)->get();

                $quotation = quotations::create([
                    'logo' => null,
                    'subject' => "Test Quotation $ii",
                    'address' => $id->address,
                    'email' => $id->email,
                    'issue_date' => now(),
                    'valid_date' => now()->addDays($ii * 3),
                    'status' => ($ii % 2 == 0),
                    'q_total' => 0,
                    'c_name' => "Client " . $ii . "- B_ID " . $id->id,
                    'c_address' => "Address $ii, City, Country",
                    'c_no' => "012-3456-00$ii",
                    'notes' => "Please confirm your order",
                    'borrower_id' => $id->id,
                ]);

                foreach ($items as $item) {
                    DB::table('quote_items')->insert([
                        'quote_id' => $quotation->id,
                        'item_id' => $item->id,
                    ]);
                }

                $quotation->update(['q_total' => $quotation->calculateQTotal()]);
            }
        }
    }
}
