<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class GigPutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'company_id' => 'required',
            'name' => 'required',
            'number_of_position' => 'required|numeric',
            'pay_per_hour' => 'required|numeric',
            'status' => 'boolean',
            'start' => 'date|nullable',
            'end' => 'date|nullable',
        ];
    }
}
