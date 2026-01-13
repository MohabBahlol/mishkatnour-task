<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCategoryRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $categoryId = $this->route('category');
        return [
            'id' => ['sometimes', 'integer', Rule::unique('categories', 'id')->ignore($categoryId)],
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('categories', 'name')->ignore($this->category),
                'regex:/^[\p{Arabic}\p{L}\s\d\-_]+$/u', // Arabic, letters, spaces, numbers, dash, underscore
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'id.integer' => 'Category ID must be an integer',
            'id.unique' => 'Category ID already exists',
            'id.sometimes' => 'Category ID is required',
            'name.required' => 'Category Name is required',
            'name.string' => 'Category Name must be a string',
            'name.min' => 'Category Name must be at least :min characters',
            'name.max' => 'Category Name must not exceed :max characters',
            'name.unique' => 'Category Name already exists',
            'name.regex' => 'Category Name contains invalid characters',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'Category Name',
            'id' => 'Category ID',
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
