<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\q_delivery_orders;
use App\Models\quotations;
use Illuminate\Http\Request;

class MADBookDeliveryOrder extends Controller
{
    public function show(quotations $quotations){
        try{
            $DO = q_delivery_orders::where('quote_id',$quotations->id)->first();
            if($DO == null)
                return response()->json('DO does not exist for this quotation');
            else
                return response()->json($DO);
        }catch(\Exception $e){
            return $e;
        }
    }
    public function store(Request $request){
        try{
            q_delivery_orders::create([
                'quote_id' => $request['quote_id'],
                'created_at' => $request['created_at'],
                'delivery_date' => $request['delivery_date'],
                'due_date' => $request['due_date'],
                'partner_by' => $request['partner_by'],
                'partner_cost' => $request['partner_cost'],
            ]);
            return response()->json('Inserted Delivery');
        }catch(\Exception $e){
            return response()->json('Error'.$e);
        }
    }
    public function update(quotations $quotations, Request $request){
        $fillables = [
            'created_at',
            'delivery_date',
            'due_date',
            'partner_by',
            'partner_cost'
        ];
        $DO = q_delivery_orders::find($quotations->id);
        $DO->update($request->only($fillables));

        return response()->json($DO);
    }
    public function delete(quotations $quotations){
        if($quotations->q_invoices()){
            return response()->json("Invoice Exist!");
        }
        $quotations->q_delivery_orders()->detach();
        $quotations->q_delivery_orders()->delete();

        return response()->json('delete');
    }
}
