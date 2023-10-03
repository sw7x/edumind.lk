<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Session\Middleware\StartSession;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Sentinel;
use App\Models\Role as RoleModel;


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


    public function render($request, Throwable $exception){
        
        //dd(sentinel::check());
        if ($this->isHttpException($exception)) {
                       
            $statuCode  =   $exception->getStatusCode();
            if ($exception->getStatusCode() == 404)
                $errorPage  =   'errors.404';

            if ($exception->getStatusCode() == 403)
                $errorPage  =   'errors.403';

            if ($exception->getStatusCode() == 500)
                $errorPage  =   'errors.500';
                        
            $errMsg  =  $exception->getMessage() ?? '';
            
            if (isset($errorPage)) {
            
                // if  ajax request
                if ($request->ajax() || $request->wantsJson())
                    return response()->json([], $statuCode);
                        
                // for guests
                if(!Sentinel::check())
                    return response()->view($errorPage, [], $statuCode);

                
                $user       = sentinel::getUser();                    
                $userRole   = optional($user->roles()->first())->name;   
                $allRoles   = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER, RoleModel::STUDENT];
                if(!in_array($userRole, $allRoles))
                    return response()->view($errorPage, [], $statuCode);     
                
                
                $view   =   ($userRole == RoleModel::STUDENT) ? 
                                $errorPage :
                                ($request->is('admin/*') ? 'admin-panel.'.$errorPage : $errorPage);

                return response()->view($view, ['errMsg' => $errMsg], $statuCode);    
                //$view = $request->is('admin/*') ? 'admin-panel.errors.404' : 'errors.404' ;                                       
            }
        }
        
        return parent::render($request, $exception);
    }





}
