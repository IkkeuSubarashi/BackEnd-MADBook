<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\BankDetails;
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
        try {
            // Validate incoming request data
            $request->validate([
                'issue_date' => 'required|date',
                'delivery_date' => 'required|date',
                'due_date' => 'required|date',
                'ship_by' => 'required|string|max:255',
                'ship_fee' => 'required|numeric',
                'c_name' => 'required|string|max:255',
                'c_no' => 'required|string',
                'c_address' => 'required|string',
                'notes' => 'nullable|string',
                'bankDetails' => 'nullable|array',
                'bankDetails.*.bank_name' => 'nullable|string|max:255',
                'bankDetails.*.acc_holder' => 'nullable|string|max:255',
                'bankDetails.*.acc_num' => 'nullable|string|max:255',
                'quote_id' => 'required|exists:quotations,id',
            ]);

            // Create Delivery Order
            $DO = q_delivery_orders::create([
                'issue_date' => now(),
                'delivery_date' => $request->input('delivery_date'),
                'due_date' => $request->input('due_date'),
                'ship_by' => $request->input('ship_by'),
                'ship_fee' => $request->input('ship_fee'),
                'c_name' => $request->input('c_name'),
                'c_no' => $request->input('c_no'),
                'c_address' => $request->input('c_address'),
                'do_total' => 0,
                'notes' => $request->input('notes'),
                'quote_id' => $request->input('quote_id'),
            ]);


            //Attach bank details if provided
            $bankDetails = [];
            if ($request->has('bankDetails') && is_array($request->input('bankDetails'))) {
                foreach ($request->input('bankDetails') as $bankDetail) {
                    $qBankDetail = BankDetails::create([
                        'bank_name' => $bankDetail['bank_name'],
                        'acc_holder' => $bankDetail['acc_holder'],
                        'acc_num' => $bankDetail['acc_num'],
                    ]);
                    $bankDetails[] = $qBankDetail->id;
                }
            }

            if (!empty($bankDetails)) {
                $DO->q_delivery_order()->attach($bankDetails);
            }

            // Calculate 'do_total' only after all bank details are attached
            $do_total = $DO->calculateDoTotal();
            $DO->update(['do_total' => $do_total]);

            return response()->json(['message' => 'Inserted Delivery Order successfully', 'delivery order' => $DO], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function update($doid, Request $request)
    {
        $quotation = quotations::find($doid);

        if (!$quotation) {
            return response()->json(['message' => ' Quotation not found'], 404);
        }

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
                $DO->update([
                    'issue_date' => $validated['issue_date'],
                    'delivery_date' => $validated['delivery_date'],
                    'due_date' => $validated['due_date'],
                    'ship_by' => $validated['ship_by'],
                    'ship_fee' => $validated['ship_fee'],
                ]);

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
                        'delivery_order_id' => $DO->id,
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
