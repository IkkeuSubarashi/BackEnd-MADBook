<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\q_delivery_orders;
use App\Models\q_invoices;
use App\Models\quotations;
use Database\Seeders\deliveryOrder;
use Illuminate\Http\Request;

class MADBookInvoice extends Controller
{
    public function show(quotations $quotations){
        try{
            $Invoice = q_invoices::where('quote_id',$quotations->id)->first();
            if($Invoice == null)
                return response()->json('Invoice does not exist for this quotation');
            else
                return response()->json($Invoice);
        }catch(\Exception $e){
            return response()->json($e);
        }
    }
    public function store(Request $request){
        try{
            q_invoices::create([
                'delivery_order_id' => $request['delivery_order_id'],
                'quote_id' => $request['quote_id'],
                'status' => $request['status'],
                'total' => $request['total'],
                'created_at' => $request['created_at'],
            ]);
            return response()->json('Inserted Invoice');
        }catch(\Exception $e){
            return response()->json('Error'.$e);
        }
        return $request;
    }
    public function delete(quotations $quotations){
        $quotations->q_invoices()->delete();
        return response()->json('delete');
    }
}
