<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate as GateFacade;
use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use App\Models\User as UserModel;

use Sentinel;
use Illuminate\Foundation\Auth\User as Authenticatable;




class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\ContactUs'  => 'App\Permissions\Policies\ContactUsPolicy',
        'App\Models\User'       => 'App\Permissions\Policies\UserPolicy',
        'App\Models\Course'     => 'App\Permissions\Policies\CoursePolicy',
        //'Sentinel'            => 'App\Policies\UserPolicy',
        'App\Models\Subject'    => 'App\Permissions\Policies\SubjectPolicy',
    ];
    
    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();
        //$this->registerPolicies($gate);

        $this->registerGates();
        
        /*
        GateFacade::define('is-admin', function(UserModel $user) {
            return $user->isAdmin();
        });
        */   
    }

    /**
     * overriden register method, called the singleton rebinding in registerAccessGate     
     */
    public function register() {
        $this->registerAccessGate();

        //todo 
        //bind sentinet::getUser() to Auth::user() 

    }

    protected function registerAccessGate()
    {
        //dd($this->app['sentinel']);

        $this->app->singleton(GateContract::class, function ($app) {
            //dd($this->app['sentinel']);
            return new Gate($app, function () use ($app) {
                return $this->app['sentinel']->getUser();
            });
        });        

    }



    public function registerGates()
    {
        $gatesFolder = base_path('app/Permissions/Gates');
        
        require_once $gatesFolder .'/contact-us-gates.php';
        require_once $gatesFolder .'/auth-gates.php';
        require_once $gatesFolder .'/cart-gates.php';        
        require_once $gatesFolder .'/admin-gates.php';
        require_once $gatesFolder .'/subject-gates.php';
    }

}
