<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCommentRequest extends FormRequest
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
            'parent_id' => 'nullable|numeric',
            'name' => 'nullable|string',
            'email' => 'nullable|string',
            'text' => 'required|string',
         ];

         if($this->route()->named('product.comments.store')) {
            $rules['product_id'] =  'required|numeric';
        }

        return $rules;
    }
}
