<?php

namespace App\Exceptions;

use App\Traits\ResponseTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
        //
    }

    public function render($request, Throwable $e)
    {
        if ($request->wantsJson()) {
            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                return $this->failed([], 'Unauthorized', 401);
            } else if ($e instanceof \Illuminate\Database\QueryException) {
                return $this->failed([], 'QueryException');
            } else if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return $this->failed([], 'Data tidak ditemukan');
            }
        }

        return parent::render($request, $e);
    }
}
