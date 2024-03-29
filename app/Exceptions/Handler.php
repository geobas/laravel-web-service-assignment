<?php

namespace App\Exceptions;

use Throwable;
use App\Helpers\HttpStatus as Status;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function(Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->api([
                'error' => 'Entity not found.',
            ], Status::NOT_FOUND);
        }

        if ($exception instanceof ValidationException) {
            return response()->api([
                'errors' => $exception->errors(),
            ], Status::BAD_REQUEST);
        }

        return parent::render($request, $exception);
    }
}
