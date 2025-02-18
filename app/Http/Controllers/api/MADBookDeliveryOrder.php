<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\q_delivery_orders;
use App\Models\q_invoices;
use App\Models\quotations;
use Barryvdh\DomPDF\Facade\Pdf;
use Database\Seeders\q_invoice;
use Illuminate\Http\Request;

class MADBookDeliveryOrder extends Controller
{
    public function allDO($borrowerId)
    {
        $qdo = q_invoices::with(['quotations', 'q_bank_details', 'q_items' => function ($query) {
            $query->select('id', 'name', 'price', 'quantity');
        }])
            ->whereHas('quotations', function ($query) use ($borrowerId) {
                $query->where('borrower_id', $borrowerId);
            })
            ->paginate(10);
        if ($qdo->isEmpty()) {
            return response()->json(['message' => 'No delivery order found for this borrower.'], 404);
        }
        return response()->json($qdo);
    }

    public function viewDO($id)
    {
        $qdo = q_delivery_orders::with([
            'q_items' => function ($query) {
                $query->select('id', 'name', 'price', 'quantity');
            },
            'quotations',
            'q_bank_details'
        ])
            ->find($id);

        if (!$qdo) {
            return response()->json(['message' => 'Delivery order not found.'], 404);
        }
        return response()->json($qdo);
    }



    public function getBankDetails($deliveryOrderId)
    {
        try {
            $deliveryOrder = q_delivery_orders::findOrFail($deliveryOrderId);
            return response()->json($deliveryOrder->bankDetails);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error: " . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'quote_id' => 'required|exists:quotations,id',
            'issue_date' => 'required|date',
            'delivery_date' => 'required|date',
            'due_date' => 'required|date',
            'ship_by' => 'required|string|max:255',
            'ship_fee' => 'required|numeric',
            'bank_name' => 'required|string|max:255',
            'acc_holder' => 'required|string|max:255',
            'acc_num' => 'required|string|max:255',
        ]);

        try {
            // Create Delivery Order
            $DO = q_delivery_orders::create($validated);

            // Create associated Bank Details
            $DO->bankDetails()->create([
                'bank_name' => $validated['bank_name'],
                'acc_holder' => $validated['acc_holder'],
                'acc_num' => $validated['acc_num'],
            ]);

            // Calculate the total
            $do_total = $DO->calculateDoTotal();

            return response()->json([
                'message' => 'Inserted Delivery Order successfully',
                'do_total' => $do_total
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
    public function update(quotations $quotation, Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'issue_date' => 'required|date',
            'delivery_date' => 'required|date',
            'due_date' => 'required|date',
            'ship_by' => 'required|string|max:255',
            'ship_fee' => 'required|numeric',
            'bank_name' => 'required|string|max:255',
            'acc_holder' => 'required|string|max:255',
            'acc_num' => 'required|string|max:255',
        ]);

        try {
            // Find the associated Delivery Order
            $DO = q_delivery_orders::where('quote_id', $quotation->id)->first();

            if ($DO) {
                // Update Delivery Order
                $DO->update($validated);

                // Check if bank details exist
                if ($DO->bankDetails) {
                    // Update Bank Details
                    $DO->bankDetails->update([
                        'bank_name' => $validated['bank_name'],
                        'acc_holder' => $validated['acc_holder'],
                        'acc_num' => $validated['acc_num'],
                    ]);
                } else {
                    // If Bank Details do not exist, create new
                    $DO->bankDetails()->create([
                        'bank_name' => $validated['bank_name'],
                        'acc_holder' => $validated['acc_holder'],
                        'acc_num' => $validated['acc_num'],
                    ]);
                }

                // Calculate the total
                $do_total = $DO->calculateDoTotal();

                return response()->json([
                    'message' => 'Delivery Order Updated successfully',
                    'delivery_order' => $DO,
                    'do_total' => $do_total
                ]);
            } else {
                return response()->json(['message' => 'Delivery Order not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function download($id)
    {
        $qdo = q_delivery_orders::with('quote_id')->find($id);

        if (!$qdo) {
            return response()->json(['message' => 'Delivery order not found'], 404);
        }

        $pdf = Pdf::loadView('delivery_order.pdf', compact('delivery_order'));

        return $pdf->download("Delivery Order-{$qdo->id}.pdf");
    }

    public function delete(quotations $quotations)
    {
        if ($quotations->q_invoices()) {
            return response()->json("Invoice Exist!");
        }
        $quotations->q_delivery_orders()->detach();
        $quotations->q_delivery_orders()->delete();

        return response()->json('delete');
    }
}
