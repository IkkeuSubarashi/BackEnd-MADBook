<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\borrower;
use App\Models\q_items;
use App\Models\quotations;

class QuotationsController extends Controller
{
    public function index(){ //All Quotations
        $quote = borrower::with([
            'quotations'
        ])->get();

        return response()->json($quote);
    }

    public function show($id){ //Quotation based on borrower id
        $quote = borrower::with([
            'quotations.q_items'
        ])
        ->where('id', $id)
        ->get()->first();

        return response()->json($quote->quotations);
    }

    public function store(Request $request){ //Store 1 quotation for a borrower
        return response()->json($request);
        try{
            // $quote = quotations::create([
            //     'logo' => $request['logo'],
            //     'subject' => $request['subject'],
            //     'valid_date' => $request['valid_date'],
            //     'status' => $request['status'],
            //     'total' => $request['total'],
            //     'created_at' => $request['created_at'],
            //     'c_name' => $request['c_name'],
            //     'c_address' => $request['c_address'],
            //     'c_no' => $request['c_no'],
            //     'borrower_id' => $request['borrower_id']
            // ]);

            $quote = quotations::create($request);
            
            foreach($request['items'] as $item){
                dd($item);
            }
            return response()->json('Inserted');

        }catch(\Exception $e){
            return response()->json('Error: '.$e->getMessage(),500);
        }
    }
}
