<?php

namespace App\Http\Requests;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ResultType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use LDAP\Result;

class BaseFormRequest  extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            (new ApiController)->apiResponse(ResultType::Error, $errors, 'Validation error!',JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
             
        );
    }
}


?>