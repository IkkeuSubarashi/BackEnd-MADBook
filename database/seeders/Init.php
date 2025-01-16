<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\borrower;
use App\Models\quotations;

class Init extends Seeder
{
    public function run(): void
    {
        $data = [
            'n' => 10,
            'subject' => 'S',
            'date' => '2025-1-15',
            'total' => 3.142,
            'address' => '123 Address',
            'no.' => '0123456789',
        ];

        for($i = 0; $i<$data['n']; $i++){
            $borrower[] = borrower::create([]);
        }

        foreach($borrower as $id){
            for($ii = 0; $ii<$data['n']; $ii++){
                $quotation [] = [
                    'logo' => null,
                    'subject' => $data['subject'],
                    'valid_date' => $data['date'],
                    'status' => ($ii%2==0),
                    'total' => $data['total'],
                    'created_at' => $data['date'],
                    'c_name' => "A id".$ii.":borrower id".$i,
                    'c_address' => $data['address'],
                    'c_no' => $data['no.'],
                    'borrower_id' => $id->id,
                ];
            }
            quotations::insert($quotation);
            $quotation = [];
        }
    }
}
