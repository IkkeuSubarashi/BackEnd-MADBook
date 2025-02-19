<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\borrower;
use App\Models\q_items;
use App\Models\quotations;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MADBookQuotation extends Controller
{
    public function allQuote($id)
    {
        try {
            //Call all quotations based on that borrower
            $quotes = borrower::with([
                'quotations.q_items',
                'quotations.q_delivery_orders',
                'quotations.q_invoices'
            ])
                ->where('id', $id)
                ->first();

            if ($quotes == null) {
                return response()->json("Id Doesnt exist");
            }

            return response()->json($quotes);
        } catch (\Exception $e) {
            return $e;
        }
    }
    public function viewQuote($id)
    {
        try {
            //Find the specific quotation by ID
            $quote = quotations::with(['borrower', 'q_items', 'q_invoices', 'q_delivery_orders'])->where('id', $id)->first();

            if (!$quote) {
                return response()->json(["message" => "Quotation not found"], 404);
            }

            return response()->json($quote);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'subject' => 'required|string|max:255',
                'logo' => 'nullable|string',  // Allow logo to be optional (can be null)
                'issue_date' => 'required|date',
                'valid_date' => 'required|date',
                'c_name' => 'required|string|max:255',
                'c_address' => 'required|string',
                'c_no' => 'required|string',
                'email' => 'required|email',  // Adding email validation
                'address' => 'required|string',
                'items' => 'required|array',
                'items.*.name' => 'required|string|max:255',
                'items.*.quantity' => 'required|numeric|min:1',
                'items.*.price' => 'required|numeric|min:0',
                'notes' => 'nullable|string',  // Allow notes to be optional
                'status' => 'nullable|integer', // Allow status to be optional
                'borrower_id' => 'nullable|integer',
            ]);

            // Create quotation
            $quote = quotations::create([
                'logo' => $request->input('logo'),
                'subject' => $request->input('subject'),
                'issue_date' => now(),
                'valid_date' => $request->input('valid_date'),
                'status' => (bool) $request->input('status', 0), // Default to false if not provided
                'c_name' => $request->input('c_name'),
                'c_address' => $request->input('c_address'),
                'c_no' => $request->input('c_no'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'q_total' => 0,
                'notes' => $request->input('notes'),
                'borrower_id' => $request->input('borrower_id')
            ]);

            // Attach items to the quotation
            $items = [];
            $totalAmount = 0;
            foreach ($request->input('items') as $item) {
                $qItem = q_items::create([
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['price'] * $item['quantity'],
                ]);
                $items[] = $qItem->id;
                $totalAmount += $qItem->total;
            }

            // Attach items to the quotation
            $quote->q_items()->attach($items);
            $quote->update(['q_total' => $totalAmount]);

            return response()->json(["message" => "New quotation saved", "quotation" => $quote], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function confirmQuotation($id)
    {
        $quotation = quotations::find($id);

        if ($quotation) {
            $quotation->status = 1;
            $quotation->save();
            return response()->json(["message" => "Quotation status changed successfully"]);
        }

        return response()->json(["message" => "Quotation not found."], 404);
    }

    public function update(Request $request, $quoteId)
    {
        try {
            // Validasi input
            $request->validate([
                'subject' => 'required|string|max:255',
                'logo' => 'nullable|string',
                'issue_date' => 'required|date',
                'valid_date' => 'required|date',
                'c_name' => 'required|string|max:255',
                'c_address' => 'required|string',
                'c_no' => 'required|string',
                'email' => 'required|email',
                'address' => 'required|string',
                'items' => 'required|array',
                'items.*.name' => 'required|string|max:255',
                'items.*.quantity' => 'required|numeric|min:1',
                'items.*.price' => 'required|numeric|min:0',
                'notes' => 'nullable|string',  // Allow notes to be optional
                'status' => 'nullable|integer' // Allow status to be optional
            ]);

            // Cari quotation yang ingin dikemaskini
            $quote = quotations::findOrFail($quoteId);

            // Kemaskini maklumat quotation
            $quote->update([
                'subject' => $request->subject,
                'logo' => $request->input('logo'),
                'issue_date' => $request->issue_date,
                'valid_date' => $request->valid_date,
                'c_name' => $request->c_name,
                'c_address' => $request->c_address,
                'c_no' => $request->c_no,
                'email' => $request->email,
                'address' => $request->address,
                'notes' => $request->notes,
                'status' => $request->status,
            ]);

            // Kemas kini items jika ada perubahan
            $items = [];
            $totalAmount = 0;

            foreach ($request->input('items') as $itemData) {
                // Kemaskini atau buat item baru jika tiada
                $qItem = q_items::updateOrCreate(
                    ['id' => $itemData['id'] ?? null], // Pastikan setiap item ada id
                    [
                        'name' => $itemData['name'],
                        'quantity' => $itemData['quantity'],
                        'price' => $itemData['price'],
                        'total' => $itemData['price'] * $itemData['quantity'],
                    ]
                );
                $items[] = $qItem->id;
                $totalAmount += $qItem->total;
            }

            // Kemas kini items yang dikaitkan dengan quotation
            $quote->q_items()->sync($items);

            // Kemaskini jumlah total quotation
            $quote->update(['q_total' => $totalAmount]);

            return response()->json(["message" => "Quotation updated successfully", "quotation" => $quote]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function download($id)
    {
        // Ambil data quotation
        $quotation = quotations::with('q_items')->find($id);

        if (!$quotation) {
            return response()->json(['message' => 'Quotation not found'], 404);
        }

        // Generate PDF dengan Blade view menggunakan Bootstrap
        $pdf = Pdf::loadView('quotations.pdf', compact('quotation'));

        // Muat turun PDF dengan nama fail
        return $pdf->download("Quotation-{$quotation->id}.pdf");
    }

    public function delete(quotations $quotations)
    {
        try {
            $quotations->q_invoices()->delete();
            $quotations->q_delivery_orders()->delete();
            $quotations->q_items()->detach();
            $quotations->delete();

            return response()->json(["message" => "Quotation deleted successfully"]);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}
