<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\borrower;
use App\Models\quotations;
use Illuminate\Http\Request;

class MADBookQuotation extends Controller
{
    public function show($id){
        try{
            //Call all quotations based on that borrower
            $quotes = borrower::with([
                'quotations.q_items',
                'quotations.q_invoices'
            ])
            ->where('id', $id)
            ->get()->first();

            if($quotes==null){
                return response()->json("Id Doesnt exist");
            }

            return response()->json($quotes);
        }catch(\Exception $e){
            return $e;
        }
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
                'borrower_id' => $request['borrower_id']
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
    public function update(quotations $quotations, Request $request){
        $fillables =  [
            'logo',
            'subject',
            'valid_date',
            'status',
            'total',
            'created_at',
            'c_name',
            'c_address',
            'c_no',
            'items',
        ];
        $quotations->update($request->only($fillables));

        if($request->has('items') && $request['items']!='' || $request['items']!=null){
            $quotations->q_items()->detach();
            $quotations->q_items()->delete();
            foreach($request['items'] as $item){
                $quotations->q_items()->create([
                    'description' => $item['description'],
                    'qty' => $item['qty'],
                    'unit_price' => $item['unit_price'],
                ]);
            }
        }
        return $quotations;
    }
    public function delete(quotations $quotations){
        $quotations->q_invoices()->delete();

        $quotations->q_delivery_orders()->delete();

        $quotations->q_items()->detach();
        $quotations->q_items()->delete();

        $quotations->delete();
        return response()->json("Delete Quotation");
    }
}
