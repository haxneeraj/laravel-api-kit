<?php

// Author: Neeraj Saini
// Email: hax-neeraj@outlook.com
// GitHub: https://github.com/haxneeraj/
// LinkedIn: https://www.linkedin.com/in/hax-neeraj/

namespace Haxneeraj\LaravelAPIKit\Http\Requests;

use Haxneeraj\LaravelAPIKit\Exceptions\ApiException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;

abstract class LaravelApiKitRequest extends FormRequest
{
    /**
     * Handle a failed validation attempt.
     *
     * This method is invoked when the request fails validation.
     * It customizes the response based on whether the request expects a JSON response or not.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Haxneeraj\LaravelAPIKit\Exceptions\ApiException
     */
    protected function failedValidation(Validator $validator)
    {
        // Check if the request expects a JSON response (e.g., API requests)
        if ($this->expectsJson()) {
            // Create a ValidationException instance
            $exception = new ValidationException($validator);
            
            // Generate a custom API error response using ApiException
            $response = (new ApiException())->handle($exception);

            // Throw a ValidationException with the custom JSON response
            throw new ValidationException($validator, $response);
        }

        // For non-JSON requests (e.g., form submissions), use the default behavior
        parent::failedValidation($validator);
    }
}
