<?php

use App\Http\Controllers\api\MADBookDeliveryOrder;
use App\Http\Controllers\api\MADBookInvoice;
use App\Http\Controllers\api\MADBookQuotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\borrower;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/datatest',function(){
    $item = borrower::with([
        'quotations',
        'quotations.q_items',
        'quotations.q_delivery_orders',
        'quotations.q_invoices',
    ])->get();

    return response()->json($item);
});

Route::get('/Quotation/{id}',[MADBookQuotation::class,'show']); //id is borrower id (does not use eloquent model)
Route::post('/Quotation/Store',[MADBookQuotation::class,'store']);
Route::patch('Quotation/Update/{quotations}',[MADBookQuotation::class,'update']);
Route::delete('Quotation/Delete/{quotations}',[MADBookQuotation::class,'delete']);

Route::get('/DO/{quotations}',[MADBookDeliveryOrder::class,'show']); //calls DO based of quotation id
Route::post('/DO/Store',[MADBookDeliveryOrder::class,'store']);
Route::patch('/DO/Update/{quotations}',[MADBookDeliveryOrder::class,'update']);
Route::delete('/DO/Delete/{quotations}',[MADBookDeliveryOrder::class,'delete']);

Route::get('/Invoice/{quoteId}',[MADBookInvoice::class,'show']);
Route::post('/Invoice/Store',[MADBookInvoice::class,'store']);
