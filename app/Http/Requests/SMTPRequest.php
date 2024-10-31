<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SMTPRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'smtp_from_email' => 'required|email',
            'smtp_from_name' => 'required',
            'driver'=>'required',
            'encryption' => 'required',
            'username' => 'required',
            'smtp_host' => 'required',
            'smtp_port' => 'required',
            'smtp_pass' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'smtp_pass' => 'smtp password',
        ];
    }
}
