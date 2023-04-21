<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClasscodeFormRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'classcode_name' => 'required|string',
            'classcode' => 'nullable|string',
            'classcode_descriptions' => 'nullable|string',
            // 'hidden_id' => 'required|integer|exists:classcodes,id', // Ensures the provided ID exists in the database
        ];
    }
}
