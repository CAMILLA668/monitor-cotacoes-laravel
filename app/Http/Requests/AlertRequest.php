<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'asset_id' => [
                'required',
                'integer',
                'exists:assets,id',
            ],

            'target_price' => [
                'required',
                'numeric',
                'gt:0',
                'decimal:0,4',
            ],

            'condition' => [
                'required',
                Rule::in([
                    'above',
                    'below',
                ]),
            ],
        ];
    }
}
