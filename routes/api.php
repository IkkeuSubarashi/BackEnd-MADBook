<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\borrower;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/datatest',function(){
    $item = borrower::with([
        'quotations' => function($query){
            $query->where('status', true)
                  ->first();
        },
        'quotations.q_items',
        'quotations.q_delivery_orders',
        'quotations.q_invoices',
    ])->first();

    return response()->json($item);
});
