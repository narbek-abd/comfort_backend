<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
         $rules = [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'bail|file|image|mimes:jpg,png'
        ];

        if($this->route()->named('products.store')) {
            $rules['category_id'] = 'required|numeric';
        } else {
            $rules['category_id'] = 'numeric';
        }

        return $rules;
    }
}
