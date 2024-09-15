<?php

namespace Haxneeraj\LaravelAPIKit\Exceptions;

use Illuminate\Validation\ValidationException as coreValidationException;
use Symfony\Component\HttpFoundation\Response;
use Haxneeraj\LaravelAPIKit\Traits\APIResponseTrait;

class ValidationException extends coreValidationException
{
    use APIResponseTrait;

    /**
     * The original exception instance.
     *
     * @var \Throwable
     */
    public $exception;

    /**
     * Constructor for the ModelNotFoundException class.
     *
     * Initializes the class with the provided exception instance.
     *
     * @param \Throwable $e The original exception that was thrown.
     */
    public function __construct(\Throwable $e)
    {
        $this->exception = $e;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * This method is called when an instance of this exception is thrown and needs to be converted
     * into an HTTP response. It formats the response using the `ResponseTrait` to ensure a consistent
     * structure for validation errors.
     *
     * 
     * @return \Haxneeraj\LaravelAPIKit\Traits\APIResponseTrait The formatted JSON response containing the error details.
     */
    public function render()
    {
        $errors = collect($this->exception->validator->errors()->messages())
        ->mapWithKeys(function ($error, $key) {
            return [$key => $error];
        });

        return $this->response(
            false,
            'Validation Error',
            [],
            $errors,
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
