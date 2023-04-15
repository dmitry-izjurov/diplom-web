<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeanceRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'time_begin' => ['required', 'string', 'min:5', 'max:5'],
            'film_id' => ['required', 'integer'],
            'hall_id' => ['required', 'integer'],
            'types_of_chairs' => ['required', 'string', 'min:6'],
            'price_of_chair' => ['required', 'string', 'min:4']
        ];
    }
}
