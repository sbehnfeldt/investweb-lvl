<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
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
        if (null === ($account = $this->route('account'))) {
            abort(400, 'No account specified in request');
        }

        if ( ! isset($account->id)) {
            abort(500, 'Account has no ID');
        }

        return [
            'company'     => 'required',
            'identifier'  => 'required|unique:accounts,' . $account->id,
            'description' => 'required'
        ];
    }
}
