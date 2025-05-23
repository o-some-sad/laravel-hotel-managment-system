<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FloorManagerRequest extends FormRequest
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
            'name' => ['required','min: 3'],
            // 'created_by' => ['required']
            // ,'exists:users,id'
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Please write a floor name.',
            'name.min' => 'Name must be at least 3 characters.',
            // 'created_by.required' => 'Please specify the manager who created this floor.',
            // 'created_by.exists' => 'The selected manager does not exist in our records.'       
        ];
    }
}
