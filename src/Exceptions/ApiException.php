<?php

// Author: Neeraj Saini
// Email: hax-neeraj@outlook.com
// GitHub: https://github.com/haxneeraj/
// LinkedIn: https://www.linkedin.com/in/hax-neeraj/

namespace Haxneeraj\LaravelAPIKit\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException as coreModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as coreNotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException as coreHttpException;
use PDOException as corePDOException;
use Illuminate\Auth\AuthenticationException as coreAuthenticationException;
use Illuminate\Validation\ValidationException as coreValidationException;
use Illuminate\Http\Exceptions\HttpResponseException as coreHttpResponseException;
use Illuminate\Database\QueryException as coreQueryException;
use Illuminate\Authentication\TokenMismatchException as coreTokenMismatchException;

use Haxneeraj\LaravelAPIKit\Exceptions\ModelNotFoundException;
use Haxneeraj\LaravelAPIKit\Exceptions\NotFoundHttpException;
use Haxneeraj\LaravelAPIKit\Exceptions\HttpException;
use Haxneeraj\LaravelAPIKit\Exceptions\PDOException;
use Haxneeraj\LaravelAPIKit\Exceptions\AuthenticationException;
use Haxneeraj\LaravelAPIKit\Exceptions\ValidationException;
use Haxneeraj\LaravelAPIKit\Exceptions\HttpResponseException;
use Haxneeraj\LaravelAPIKit\Exceptions\QueryException;
use Haxneeraj\LaravelAPIKit\Exceptions\TokenMismatchException;

use Haxneeraj\LaravelAPIKit\Traits\APIResponseTrait;

/**
 * Class ApiException
 *
 * A basic exception handler class that provides a method for handling exceptions.
 * This class can be used to customize how exceptions are handled and reported within
 * the application.
 */
class ApiException
{
    use APIResponseTrait;
    /**
     * Handles an exception thrown during the application's execution.
     *
     * @param \Throwable $e The exception that was thrown.
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(\Throwable $e)
    {
        if (config('laravel-api-kit.dev_mode') === true):
            return $this->response(false, $e->getMessage(), [], [], 500);
        elseif(config('laravel-api-kit.dev_mode') == 'dev'):
            dd([
                'Error' => $e->getMessage(),
                'File' => $e->getFile(),
                'Line' => $e->getLine(),
                'Trace' => $e->getTraceAsString()
            ]);
        endif;

        return match (true) {
            $e instanceof coreModelNotFoundException => (new ModelNotFoundException($e))->render(),
            $e instanceof coreNotFoundHttpException => (new NotFoundHttpException($e))->render(),
            $e instanceof coreHttpException => (new HttpException($e))->render(),
            $e instanceof corePDOException => (new PDOException($e))->render(),
            $e instanceof coreAuthenticationException => (new AuthenticationException($e))->render(),
            $e instanceof coreValidationException => (new ValidationException($e))->render(),
            $e instanceof coreHttpResponseException => (new HttpResponseException($e))->render(),
            $e instanceof coreQueryException => (new QueryException($e))->render(),
            $e instanceof coreTokenMismatchException => (new TokenMismatchException($e))->render(),
            default => $this->response(false, __('LaravelAPIKit::message.something_went_wrong'), 500),
        };
    }
}
