<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaryStoreRequest extends FormRequest
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
            'staff_id' => 'required|numeric',
            'amount' =>  'required|numeric',
            'date' => 'required|date',
            'month' => 'required|string',
            'year' => 'required|string',
            'type' => 'required|in:regular,advance,late',
        ];
    }
}
