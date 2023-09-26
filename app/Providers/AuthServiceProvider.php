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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',        
        'App\Models\ContactUs' => 'App\Policies\ContactUsPolicy',
        'App\Models\User'       => 'App\Policies\UserPolicy',
        'App\Models\Course'     => 'App\Policies\CoursePolicy',
        //'Sentinel'       => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
    
    public function boot()
    {
        $this->registerPolicies();

        //
    } 
    */




    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        //
        
        GateFacade::define('is_admin', function(UserModel $user) {
            return $user->isAdmin();
        });

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
















}
