<?php

use App\Http\Controllers\api\MADBookDeliveryOrder;
use App\Http\Controllers\api\MADBookInvoice;
use App\Http\Controllers\api\MADBookQuotation;
use App\Http\Controllers\BorrowerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\borrower;


Route::options('/{any}', function (Request $request) {
    return response()->json(['status' => 'success'], 200, [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
    ]);
})->where('any', '.*');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/datatest', function () {
    $item = borrower::with([
        'quotations',
        'quotations.q_items',
        'quotations.q_delivery_orders',
        'quotations.q_invoices',
    ])->get();

    return response()->json($item);
});

Route::get('/Borrower/{id}', [BorrowerController::class, 'show']);

Route::get('/Borrower/{id}/Quotation', [MADBookQuotation::class, 'allQuote']); //id is borrower id (does not use eloquent model)
Route::get('/Quotation/{id}', [MADBookQuotation::class, 'viewQuote']);
Route::get('Quotation/{id}/Download', [MADBookQuotation::class, 'download']);
Route::post('/Quotation/Store', [MADBookQuotation::class, 'store']);
Route::put('Quotation/{id}/Confirm', [MADBookQuotation::class, 'confirmQuotation']);
Route::put('Quotation/Update/{quoteId}', [MADBookQuotation::class, 'update']);
Route::delete('Quotation/Delete/{id}', [MADBookQuotation::class, 'delete']);

Route::get('/All/DO/{borrowerId}', [MADBookDeliveryOrder::class, 'allDo']); //calls DO based of quotation id
Route::get('/DO/{id}', [MADBookDeliveryOrder::class, 'viewDO']);
Route::post('/DO/Store', [MADBookDeliveryOrder::class, 'store']);
Route::put('/DO/Update/{id}', [MADBookDeliveryOrder::class, 'update']);
Route::delete('/DO/Delete/{id}', [MADBookDeliveryOrder::class, 'delete']);
Route::get('DO/{id}/BankDetails', [MADBookDeliveryOrder::class, 'getBankDetails']);
Route::get('DO/{id}/Download', [MADBookDeliveryOrder::class, 'download']);


Route::get('/All/Invoices/{borrowerId}', [MADBookInvoice::class, 'show']);
Route::get('/Invoice/{id}', [MADBookInvoice::class, 'viewInvoice']);
Route::post('/Invoice/Store', [MADBookInvoice::class, 'store']);
Route::get('/Invoice/{id}/Status', [MADBookInvoice::class, 'updatePaymentStatus']);
Route::get('Invoice/{id}/Download', [MADBookInvoice::class, 'download']);
