<?php

namespace Enan\PathaoCourier\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Enan\PathaoCourier\Services\Exceptions\PathaoException;
use Symfony\Component\HttpFoundation\Response as HttpResponseCode;


class BasePathaoRequest extends FormRequest
{
    /**
     * Handle a failed validation attempt based on request source.
     * If request source came from API, we will use the default behaviour,
     * otherwise we will use the toast notification for web to display the validation messages.
     *
     * @param Validator $validator
     * @return void
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator)
    {
        throw new PathaoException("Validation Error", HttpResponseCode::HTTP_EXPECTATION_FAILED, $validator->errors());
    }
}
