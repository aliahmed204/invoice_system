<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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

                'product_name'=>'required|string|unique:products|min:6|max:255',
                'description'=>'required|min:6',
                'section_id'=>'required',
        ];
    }

    public function attributes()
    {
      return [ // need language file
            'section_name.required'=>'يرجى أدخال أسم القسم ',
            'section_name.unique'=>' خطأ القسم مسجل مسبقا ',
            'description.required'=>' يرجى أدخال وصف للقسم ',
            'description.min'=>' وصف القسم لا يجب ان يقل عن 6 احرف ',
        ];
    }
}
