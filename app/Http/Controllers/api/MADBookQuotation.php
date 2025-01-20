<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quotation;
use App\Models\borrower;
use App\Models\quotations;
use Illuminate\Http\Request;

class MADBookQuotation extends Controller
{
    public function show($id, $case){
        switch($case){
            case 'quotes':
                $quotes = borrower::with([
                    'quotations'
                ])
                ->where('id', $id)
                ->get()->first();

                return response()->json($quotes->quotations);
            case 'quote':
                $quote = quotations::with([
                    'q_items'
                ])
                ->where('id', $id)
                ->get()->first();

                return response()->json($quote);
        }
    }
    public function store(Quotation $request){ // Quotation Request class
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

        }catch(\Exception $e){
            return response()->json('Error: '.$e->getMessage(),500);
        }
    }
}
