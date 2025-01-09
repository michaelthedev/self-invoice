<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reference' => ['sometimes', 'nullable', 'string'],
            'currency' => ['required', 'string'],

            'items' => ['required', 'array'],
            'items.*.description' => ['required', 'string'],
            'items.*.quantity' => ['required', 'numeric', 'min:1'],
            'items.*.unit' => ['required', 'numeric'],
            'tax' => ['required', 'numeric', 'min:0'],
            'note' => ['sometimes', 'nullable', 'string'],

            'client_id' => ['required', 'exists:clients,id'],
            'project_id' => ['required', 'exists:projects,id'],
        ];
    }
}
