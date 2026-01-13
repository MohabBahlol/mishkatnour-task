<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['nullable', 'integer', Rule::unique('categories', 'id')],
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'unique:categories',
                'regex:/^[\p{Arabic}\p{L}\s\d\-_]+$/u', // Arabic, letters, spaces, numbers, dash, underscore
            ],
            'price' => ['required', 'numeric', 'gt:0'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'id.integer' => 'Product ID must be an integer',
            'id.unique' => 'Product ID already exists',
            'name.required' => 'Product Name is required',
            'name.string' => 'Product Name must be a string',
            'name.min' => 'Product Name must be at least :min characters',
            'name.max' => 'Product Name must not exceed :max characters',
            'name.unique' => 'Product Name already exists',
            'name.regex' => 'Product Name contains invalid characters',
            'price.required' => 'Product Price is required',
            'price.numeric' => 'Product Price must be a number',
            'price.gt' => 'Product Price must be greater than 0',
            'category_id.required' => 'Category ID is required',
            'category_id.exists' => 'Category ID does not exist',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'Product Name',
            'id' => 'Product ID',
            'price' => 'Product Price',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Handle a failed validation attempt (for API).
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422)
        );
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim($this->name),
        ]);
    }
}
