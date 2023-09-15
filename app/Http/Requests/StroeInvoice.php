<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StroeInvoice extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "invoice_number"     => 'required|string|min:3|max:55' ,
            "invoice_date"       => 'required|date' ,
            "due_date"           => 'required|date' ,
            "Section"            => 'required|numeric' ,
            "product"            => 'required|string' ,
            "Amount_collection"  => 'required|numeric' ,
            "Amount_Commission"  => 'required|numeric' ,
            "Discount"           => 'nullable|numeric' ,
            "Rate_VAT"           => 'required|string' ,
            "Value_VAT"          => 'required|numeric' ,
            "Total"              => 'required|numeric' ,
            "note"               => 'required|string|min:6|max:85' ,
        ];
    }
}
