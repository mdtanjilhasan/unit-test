<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProductStoreValidation extends FormRequest
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
        return [
            'name' => 'required|string',
            'code' => $this->getCodeRule(),
            'price' => 'required|numeric',
            'product_id' => 'sometimes|required|integer|exists:products,id'
        ];
    }

    private function getCodeRule()
    {
        return request('product_id') ? ['required', 'string', Rule::unique('products', 'code')->ignore(request('product_id'), 'id')] : 'required|string|unique:products,code';
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
