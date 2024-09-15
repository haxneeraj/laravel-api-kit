<?php 

// Author: Neeraj Saini
// Email: hax-neeraj@outlook.com
// GitHub: https://github.com/haxneeraj/
// LinkedIn: https://www.linkedin.com/in/hax-neeraj/

namespace Haxneeraj\LaravelAPIKit\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait APIResponseTrait
{
    /**
     * General response method to return a JSON response.
     *
     * @param bool $status The status of the response, true for success, false for error.
     * @param string $message A message providing more context about the response.
     * @param array $data The data to be returned with the response.
     * @param array $errors Any errors associated with the response.
     * @param int $code The HTTP status code for the response.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the mixed(success/error) response.
     */
    public function response($status = true, $message = '', $data = [], $errors = [], $code = Response::HTTP_OK): JsonResponse
    {
        // Define the response data
        $responseData = [
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'errors' => $errors,
        ];

        // Return the JSON response with the response data and the specified HTTP status code and content type header depends on the status
        if ($status) {
            return new JsonResponse($responseData, $code, [
                'Content-Type' => 'application/json',
            ]);
        } else {
            return new JsonResponse($responseData, $code, [
                'Content-Type' => 'application/problem+json',
            ]);
        }
    }

    /**
     * Respond with a 201 Created status.
     *
     * @param string|null $message The success message for the created resource.
     * @param array $data The data of the created resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseCreated(?string $message = null, array $data = []): JsonResponse
    {
        $message = $message ?: __('LaravelAPIKit::message.created_success');
        return $this->response(true, $message, $data, [], Response::HTTP_CREATED);
    }

    /**
     * Respond with a 204 No Content status, typically used after a resource is deleted.
     *
     * @param string|null $message The success message for the deleted resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseDeleted(?string $message = null): JsonResponse
    {
        $message = $message ?: __('LaravelAPIKit::message.deleted_success');
        return $this->response(true, $message, [], [], Response::HTTP_NO_CONTENT);
    }

    /**
     * Respond with a 404 Not Found status.
     *
     * @param string|null $errorTitle The title of the error.
     * @param mixed $errorDetails Detailed information about the error. Can be an array or other types.
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseNotFound(?string $errorTitle = null, mixed $errorDetails = null): JsonResponse
    {
        $errorTitle = $errorTitle ?: __('LaravelAPIKit::message.not_found');
        $errorDetails = $errorDetails ?: ['error' => __('LaravelAPIKit::message.not_found')];

        return $this->response(false, $errorTitle, [], $errorDetails, Response::HTTP_NOT_FOUND);
    }

    /**
     * Respond with a 400 Bad Request status.
     *
     * @param string|null $errorTitle The title of the error.
     * @param mixed $errorDetails Detailed information about the error. Can be an array or other types.
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseBadRequest(?string $errorTitle = null, mixed $errorDetails = null): JsonResponse
    {
        $errorTitle = $errorTitle ?: __('LaravelAPIKit::message.bad_request');
        $errorDetails = $errorDetails ?: ['error' => __('LaravelAPIKit::message.bad_request')];

        return $this->response(false, $errorTitle, [], $errorDetails, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Respond with a 403 Forbidden status.
     *
     * @param string|null $errorTitle The title of the error.
     * @param mixed $errorDetails Detailed information about the error. Can be an array or other types.
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseUnAuthorized(?string $errorTitle = null, mixed $errorDetails = null): JsonResponse
    {
        $errorTitle = $errorTitle ?: __('LaravelAPIKit::message.unauthorized');
        $errorDetails = $errorDetails ?: ['error' => __('LaravelAPIKit::message.unauthorized')];

        return $this->response(false, $errorTitle, [], $errorDetails, Response::HTTP_FORBIDDEN);
    }

    /**
     * Respond with a 409 Conflict status.
     *
     * @param string|null $errorTitle The title of the error.
     * @param mixed $errorDetails Detailed information about the error. Can be an array or other types.
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseConflictError(?string $errorTitle = null, mixed $errorDetails = null): JsonResponse
    {
        $errorTitle = $errorTitle ?: __('LaravelAPIKit::message.conflict');
        $errorDetails = $errorDetails ?: ['error' => __('LaravelAPIKit::message.conflict')];

        return $this->response(false, $errorTitle, [], $errorDetails, Response::HTTP_CONFLICT);
    }

    /**
     * Respond with a 422 Unprocessable Entity status, commonly used for validation errors.
     *
     * @param string|null $errorTitle The title of the error.
     * @param mixed $errorDetails Detailed information about the error. Can be an array or other types.
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseUnprocessable(?string $errorTitle = null, mixed $errorDetails = null): JsonResponse
    {
        $errorTitle = $errorTitle ?: __('LaravelAPIKit::message.unprocessable_entity');
        $errorDetails = $errorDetails ?: ['error' => __('LaravelAPIKit::message.unprocessable_entity')];

        return $this->response(false, $errorTitle, [], $errorDetails, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Respond with a 401 Unauthorized status when authentication fails or is not provided.
     *
     * @param string|null $errorTitle The title of the error.
     * @param mixed $errorDetails Detailed information about the error. Can be an array or other types.
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseUnAuthenticated(?string $errorTitle = null, mixed $errorDetails = null): JsonResponse
    {
        $errorTitle = $errorTitle ?: __('LaravelAPIKit::message.unauthenticated');
        $errorDetails = $errorDetails ?: ['error' => __('LaravelAPIKit::message.unauthenticated')];

        return $this->response(false, $errorTitle, [], $errorDetails, Response::HTTP_UNAUTHORIZED);
    }
}
