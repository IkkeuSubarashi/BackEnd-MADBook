<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\q_delivery_orders;
use App\Models\quotations;
use Illuminate\Http\Request;

class MADBookDeliveryOrder extends Controller
{
    public function show($id){
        try{
            $quote = quotations::find($id);
            $DO = q_delivery_orders::where('quote_id',$quote->id)->first();
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
}
