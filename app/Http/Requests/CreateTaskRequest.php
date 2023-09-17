<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'subject'     => 'required|string|between:20,100',
            'description' => 'string|between:20,300',
            'type'        => 'required|in:bug,feature,support',
            'status'      => 'in:new,in_progress,resolved,feedback,closed,rejected',
            'start_date'  => 'date',
            'due_date'    => 'date|after:start_date',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }
}
