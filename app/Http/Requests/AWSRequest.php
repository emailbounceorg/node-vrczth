<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AWSRequest extends FormRequest
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
            'from_email' => 'required|email',
            'from_name' => 'required',
            'awsBucket' => 'required',
            'awsDefaultRegion'=>'required',
            'awsSecretKey' => 'required',
            'awsAccessKey'=>'required',
            'driver' => 'required',
        ];
    }

     function attributes() : array {
        return [
            'awsBucket' =>  'AWS Bucket',
            'awsDefaultRegion' => 'AWS Default Region',
            'awsSecretKey' => 'AWS Secret Key',
            'awsAccessKey' => 'AWS Access Key',
        ];
    }
}
