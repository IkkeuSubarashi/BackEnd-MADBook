<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\borrower;
use App\Models\q_delivery_orders;
use App\Models\q_invoices;
use App\Models\quotations;
use Barryvdh\DomPDF\Facade\Pdf;
use Database\Seeders\deliveryOrder;
use Database\Seeders\q_invoice;
use Illuminate\Http\Request;

class MADBookInvoice extends Controller
{

    public function show($id)
    {
        try {
            $Invoice = q_invoices::with('quotations') //calls invoices based of the borrower id and including the data of the quotation related to the invoices
                ->whereHas('quotations', function ($query) use ($id) {
                    $query->where('borrower_id', $id);
                })->get();
            if ($Invoice == null)
                return response()->json('Invoice does not exist for this quotation');
            else
                return response()->json($Invoice);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    // public function allInvoice($borrowerId)
    // {
    //     $invoices = q_invoices::with(['quotations', 'q_delivery_orders', 'q_items' => function ($query) {
    //         $query->select('id', 'name', 'price', 'quantity');
    //     }])
    //         ->whereHas('quotations', function ($query) use ($borrowerId) {
    //             $query->where('borrower_id', $borrowerId);
    //         })
    //         ->get();
    //     if ($invoices->isEmpty()) {
    //         return response()->json(['message' => 'No invoices found for this borrower.'], 404);
    //     }
    //     return response()->json($invoices);
    // }

    public function viewInvoice($id)
    {
        // try {
        //     $invoice = q_invoices::with(['quotations', 'q_delivery_orders.q_items'])
        //         ->whereHas('quotations', function ($query) use ($id) {
        //             $query->where('borrower_id', $id);
        //         })->first();

        //     if (!$invoice) {
        //         return response()->json(['message' => 'Invoice does not exist for this quotation'], 404);
        //     }

        //     return response()->json([
        //         'invoice' => $invoice,
        //         'quotation' => $invoice->quotations,
        //         'delivery_order' => $invoice->q_delivery_orders,
        //         'items' => $invoice->q_delivery_orders ? $invoice->q_delivery_orders->q_items : [],
        //     ]);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], 500);
        // }

        try {
            //Find the specific quotation by ID
            $invoice = q_invoices::with(['quotations', 'q_items', 'q_delivery_orders', 'q_bank_details'])->where('id', $id)->first();

            if (!$invoice) {
                return response()->json(["message" => "Invoice not found"], 404);
            }

            return response()->json($invoice);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $deliveryOrder = q_delivery_orders::where('quote_id', $request->quote_id)->first();

            if (!$deliveryOrder) {
                return response()->json(["error" => "Delivery order not found"], 404);
            }

            $invoice = q_invoices::create([
                'delivery_order_id' => $deliveryOrder->id,
                'quote_id' => $deliveryOrder->quote_id,
                'status' => 'Pending',
                'i_total' => $deliveryOrder->do_total,
                'issue_date' => now(),
            ]);
            return response()->json(["message", "Invoice created successfully", 'invoice' => $invoice]);
        } catch (\Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }
        return $request;
    }

    public function updatePaymentStatus($invoiceId, Request $request)
    {
        $invoice = q_invoices::findOrFail($invoiceId);

        $validatedData = $request->validate([
            'status' => 'required|in:Pending,Paid,Canceled'
        ]);

        $invoice->status = $validatedData['status'];
        $invoice->save();

        return response()->json(['message' => 'Invoice status updated successfully.'], 200);
    }

    public function download($id)
    {
        $invoice = q_invoices::with('quote_id', 'delivery_order_id')->find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Delivery order not found'], 404);
        }

        $pdf = Pdf::loadView('invoice.pdf', compact('invoice'));

        return $pdf->download("Invoice-{$invoice->id}.pdf");
    }
    public function delete(quotations $quotations)
    {
        $quotations->q_invoices()->delete();
        return response()->json('delete');
    }
}
