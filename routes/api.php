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

Route::get('/Quotation/{id}',[MADBookQuotation::class,'show']);
Route::post('/Quotation/Store',[MADBookQuotation::class,'store']);

Route::get('/DO/{quoteId}',[MADBookDeliveryOrder::class,'show']);
Route::post('/DO/Store',[MADBookDeliveryOrder::class,'store']);

Route::get('/Invoice/{quoteId}',[MADBookInvoice::class,'show']);
Route::post('/Invoice/Store',[MADBookInvoice::class,'store']);
