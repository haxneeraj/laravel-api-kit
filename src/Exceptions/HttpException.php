<?php

// Author: Neeraj Saini
// Email: hax-neeraj@outlook.com
// GitHub: https://github.com/haxneeraj/
// LinkedIn: https://www.linkedin.com/in/hax-neeraj/

namespace Haxneeraj\LaravelAPIKit\Exceptions;

use Haxneeraj\LaravelAPIKit\Traits\APIResponseTrait;

/**
 * Custom exception class for handling model not found errors.
 * 
 * This class is used to create a custom response for scenarios where a model
 * could not be found in the database. It uses the `APIResponseTrait` to ensure
 * consistent formatting of the error response.
 */
class HttpException
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
     * This method converts the exception into a formatted HTTP response using
     * the `ResponseTrait`. It returns a JSON response with error details.
     *
     * @return \Illuminate\Http\JsonResponse The formatted JSON response containing the error details.
     */
    public function render()
    {
        // dd($this->exception);

        // Return a JSON response using the `response` method from `ResponseTrait`.
        return $this->response(false, $this->getMessage());
    }

    /**
     * Get the message for the exception.
     *
     * This method constructs a message based on the model class and ID
     * from the original exception. It uses localization for error messages.
     *
     * @return string The error message formatted with model class and ID.
     */
    public function getMessage()
    {
        $statusCode = $this->exception->getStatusCode();

        return match(true)
        {
            $statusCode == 404 => __('LaravelAPIKit::message.not_found'),
            $statusCode == 400 => __('LaravelAPIKit::message.bad_request'),
            $statusCode == 419 => __('LaravelAPIKit::message.token_expired'),
            default => __('LaravelAPIKit::message.something_went_wrong'),
        };
    }
}