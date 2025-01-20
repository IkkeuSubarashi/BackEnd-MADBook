<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Quotation extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
                'subject' => 'required',
                'valid_date' => 'required',
                'total' => 'required',
                'c_name' => 'required',
                'c_address' => 'required',
                'c_no' => 'required',
                'items' => 'required|array',
                'items.*.description' => 'required',
                'items.*.qty' => 'required',
                'items.*unit_price' => 'required',
        ];
    }
}
