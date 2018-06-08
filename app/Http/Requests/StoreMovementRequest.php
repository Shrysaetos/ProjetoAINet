<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovementRequest extends FormRequest
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
            'movement_category_id'=>'required|exists:movement_categories,id',
            'description' => 'nullable|max:255',
            'date' => 'required|date',
            'value' => 'required|numeric|min:0.1',
            'document_file' => 'nullable|file',
            'document_description' => 'nullable|max:255',

        ];
    }
}
