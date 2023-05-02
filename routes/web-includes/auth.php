<?php 



use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController as User_LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\ActivationController;
use App\Http\Controllers\Auth\ChangePasswordController;


use App\Http\Controllers\Admin\auth\LoginController as Admin_LoginController;
use App\Http\Controllers\Admin\Auth\ChangeAdminPasswordController;




Route::group(['as'=>'auth.','namespace' =>'Auth'], function() {

    Route::group(['middleware'=> 'noAdminUser'], function(){

        Route::get('/reset-password', [ForgotPasswordController::class,'forgotPassword'])->name ('reset-password');
        Route::post('/reset-password', [ForgotPasswordController::class,'postForgotPassword'])->name ('reset-password-submit');

        Route::get('/reset/{email}/{resetCode}', [ForgotPasswordController::class,'resetPassword'])->name ('reset-password-form');
        Route::post('/reset/{email}/{resetCode}', [ForgotPasswordController::class,'postResetPassword'])->name ('reset-password-form-submit');

        Route::get ('/login', [User_LoginController::class,'login'])->name ('login');
        Route::post ('/login', [User_LoginController::class,'loginSubmit'])->name ('login-submit');

        Route::get ('/register', [RegistrationController::class,'register'])->name ('register');
        Route::post ('/register', [RegistrationController::class,'postRegister'])->name ('register-submit');

        //form-teacher-register.blade

        Route::get ('/teacher-register', [RegistrationController::class,'teacherRegister'])->name('teacher-register');
        Route::post ('/teacher-register', [RegistrationController::class,'postTeacherRegister'])->name('teacher-register-submit');

        Route::get ('/activate/{encrypted_email}/{activation_code}', [ActivationController::class,'activate'])->name ('activate');


    });
    Route::get('/change-password', [ChangePasswordController::class,'changePassword'])->name ('change-password');
    Route::post('/change-password', [ChangePasswordController::class,'postChangePassword'])->name ('change-password-submit');

    Route::post ('/logout', [User_LoginController::class,'logout'])->name('logout');

});





Route::group(['prefix'=>'admin','as'=>'admin.'], function(){
    Route::group(['namespace'=>'Admin'], function(){       
        Route::group(['namespace'=>'auth'], function(){
            //dump('ss');
            //Route::get ('', [Admin_LoginController::class,'adminLogin'])->name ('login');
            //Route::post ('', [Admin_LoginController::class,'adminLoginSubmit'])->name ('login-submit');
            //Route::post ('/change-password', [ChangeAdminPasswordController::class,'changePassword'])->name('changePassword');
        });
    });
});