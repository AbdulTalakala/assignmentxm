<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'companySymbol' => 'required|min:1|max:5|regex:/^[A-Z]+$/|exists:company_details,symbol',
            'email' => 'required|email',
            'startDate' => 'required|date|date_format:Y-m-d|before_or_equal:endDate|before_or_equal:today',
            'endDate' => 'required|date|date_format:Y-m-d|after_or_equal:startDate||before_or_equal:today'
        ];
    }
}
