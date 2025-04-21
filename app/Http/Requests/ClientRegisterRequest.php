<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
use Lwwcas\LaravelCountries\Models\Country;



class ClientRegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', 'min:6'],
            'country' => [
                'required',
                'integer',
                'exists:lc_countries,id',
            ],
            'gender' => 'required|in:male,female',
            'avatar_image' => [
                'nullable',
                File::image()
                    ->types(['jpg', 'jpeg'])
                    ->max(2 * 1024),
            ],
        ];
    }
}
