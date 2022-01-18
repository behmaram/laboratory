<?php

namespace App\Exceptions;

use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];


    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Throwable $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            if ($exception instanceof ValidationException) {
                return response([
                    'data' => '',
                    'message' => array_values($exception->errors())[0][0],
                    'status' => false
                ], $exception->status);
            }

            if ($exception instanceof HttpException) {
                $status = $exception->getStatusCode();
                $message = $exception->getMessage();
                return response([
                    'data' => '',
                    'message' => $message ?? __('http_exception.' . $status),
                    'status' => false
                ], $status);
            }

            if ($exception instanceof AuthorizationException) {
                return response([
                    'data' => '',
                    'message' => __('messages.access_denied'),
                    'status' => false
                ], $exception->getCode() ?? Response::HTTP_UNAUTHORIZED);
            }

            if ($exception instanceof AuthenticationException) {
                return response([
                    'data' => '',
                    'message' => __('messages.access_denied'),
                    'status' => false
                ], 401);
            }

            if ($exception instanceof ModelNotFoundException) {
                $exception = $exception->getMessage();
                return response([
                    'data' => '',
                    'message' => $exception,
                    'status' => false
                ], Response::HTTP_NOT_FOUND);
            }
        }

//        if ($exception instanceof CustomException) {
//            return response()->view('errors.exist-plan', [], 404);
//        }

        return parent::render($request, $exception);
    }
}
