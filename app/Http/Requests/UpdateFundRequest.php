<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFundRequest extends FormRequest
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
     *
     */
    public function rules(): array
    {
        if (null === ($fund = $this->route('fund'))) {
            abort(400, 'No fund specified in request');
        }

        if ( ! isset($fund->id)) {
            abort(500, 'Fund has no ID');
        }

        return [
            'name'        => 'required',
            'symbol'      => 'required|unique:funds,' . $fund->id,
            'description' => 'required',
            'asset_class' => 'required'
        ];
    }
}
