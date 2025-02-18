<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\borrower;

class BorrowerController extends Controller
{
    public function show($id)
    {
        $borrower = Borrower::find($id);

        if ($borrower) {
            return response()->json($borrower);
        }

        return response()->json(['message' => 'Borrower not found'], 404);
    }
}
