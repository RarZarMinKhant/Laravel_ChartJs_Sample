<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount'=> 'required',
            'note'=>'required',
            'finance_date'=>'required',
            'type'=>'required'
        ];
    }
}
