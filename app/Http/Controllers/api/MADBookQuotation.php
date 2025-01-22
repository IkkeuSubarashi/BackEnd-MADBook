<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\borrower;
use App\Models\quotations;
use Illuminate\Http\Request;

class MADBookQuotation extends Controller
{
    public function show($id){
                $quotes = borrower::with([
                    'quotations.q_items'
                ])
                ->where('id', $id)
                ->get()->first();

                return response()->json($quotes);

    }
    public function store(Request $request){ // Quotation store
        try{
            $quote = quotations::create([
                'logo' => $request['logo'],
                'subject' => $request['subject'],
                'valid_date' => $request['valid_date'],
                'status' => 0,
                'total' => $request['total'],
                'created_at' => now(),
                'c_name' => $request['c_name'],
                'c_address' => $request['c_address'],
                'c_no' => $request['c_no'],
                'borrower_id' => 1
            ]);

            foreach($request['items'] as $item){
                $quote->q_items()->create([
                    'description' => $item['description'],
                    'qty' => $item['qty'],
                    'unit_price' => $item['unit_price'],
                ]);
            }
            return response()->json('Insert Quotation');
        }catch(\Exception $e){
            return response()->json('Error: '.$e->getMessage(),500);
        }
    }
}
