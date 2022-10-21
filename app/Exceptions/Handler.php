<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Session\Middleware\StartSession;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Sentinel;


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
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    /**/
    public function render($request, Throwable $exception)
    {
        //dd(sentinel::check());
        if ($this->isHttpException($exception)) {
            //HTTP - 404
            if ($exception->getStatusCode() == 404) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([], 404);
                }else{
                    $view = $request->is('admin/*') ? 'admin.errors.404' : 'errors.404' ;
                    return response()->view($view, [], 404);
                }
            }
           // if ($exception->getStatusCode() == 403) {
           //     //return response()->view('errors.' . '403', [], 403);
           //     dd('http-403');
           // }

           // if ($exception->getStatusCode() == 500) {
           //     return response()->view('errors.' . '500', [], 500);
           // }
        }
        return parent::render($request, $exception);
    }





}
