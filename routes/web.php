<?php

//use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*
---Middleware---
'CheckStudent'
'CheckAdmin'
'CheckEditor'
'checkGuest'
'CheckIsAdminUser'
'CheckLoginUser'
'CheckMarketer'
'CheckTeacher'
*/



use App\Http\Controllers\Admin\ContactUsMessagesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\ContactUsMessagesController as User_ContactUsMessagesController;
use App\Http\Controllers\Admin\CourseController as Admin_CourseController;
use App\Http\Controllers\Admin\UserController;


use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Admin\TeacherController as Admin_TeacherController;
use App\Http\Controllers\Admin\MarketerController as Admin_MarketerController;

use App\Http\Controllers\TopicsController;
use App\Http\Controllers\CourseController as User_CourseController;



use App\Http\Controllers\Admin\auth\LoginController as Admin_LoginController;
use App\Http\Controllers\Admin\Auth\ChangeAdminPasswordController;


use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\ActivationController;
use App\Http\Controllers\Auth\LoginController as User_LoginController;


use App\Models\Subject;
use App\Models\User;



use Illuminate\Support\Facades\DB;
Route::get('/test123', function () {
    $ff = Subject::find(1);
    dump($ff);

	$ff = Subject::find(1)->courses;
    dump($ff);
	
	//$ff = Subject::find(1)->courses->where('name','ee')->get();
   	//dump($ff);





	$ff = Subject::find(1)->courses();
    dump($ff);


	$ff = Subject::find(1)->courses()->where('name','like','%ee%')->get();
    dump($ff);
});





//create storage link
Route::get('/storage-link', function () {
    Artisan::call('storage:link');
});




/***** clear cache commands ****/
//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache: 
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});







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






Route::get('/form-submit-page', function () {    return view('form-submit-page');})->name('form-submit-page');
Route::get('/coming-soon', function () {    return view('coming-soon');})->name('coming-soon');
Route::get ('/', [HomeController::class,'index'])->name ('home');
Route::get ('/no-permission', [PageController::class,'pageNoPermission'])->name ('no-permission');
Route::get('/search2',function(){    return view('search-2');})->name('search2');
Route::get('/404',function(){    return view('errors.404');})->name('404');
Route::get('/403',function(){    return view('errors.403');})->name('403');
Route::get('/courses-list',function(){    return view('courses-list');})->name('courses-list');
Route::get('/about-us',function(){    return view('about-us');})->name('about-us');
Route::get('/why-choose-us',function(){    return view('why-edumind');})->name('why-choose-us');
//Route::get('/page-privacy',function(){ return view('privacy-policy-page');})->name('privacy-policy');
Route::get('/default-page',function(){ return view('default-page');})->name('default-page');
Route::get('/faq',function(){ return view('faq-page');})->name('faq');
Route::get('/bill-info',function(){ return view('bill-info');})->name('bill-info');
Route::get('/empty',function(){ return view('empty');})->name('empty');
Route::get('/help',function(){ return view('help-page');})->name('help');
Route::get('/cart',function(){ return view('cart');})->name('cart');
Route::get('/terms-and-services',function(){ return view('terms-and-services');})->name('terms-and-services');
Route::get('/courses',function(){ return view('courses');})->name('courses');
Route::get('/search',function(){ return view('search');})->name('search');
Route::get('/test',function(){ return view('test');})->name('test');

//Route::get('/course-watch', function () {     return view('course-watch'); })->name('course-watch');
Route::get ('/course/guest-enroll', [User_CourseController::class,'guestEnroll'])->name ('course-guest-enroll');
Route::post ('/course/enroll', [User_CourseController::class,'enroll'])->name ('course.enroll');
Route::post ('/course/complete', [User_CourseController::class,'complete'])->name ('course.complete');
Route::get ('/course/{slug?}', [User_CourseController::class,'ViewCourse'])->name('course-single');
Route::get ('/course/watch/{slug?}/{videoId?}', [User_CourseController::class,'watchCourse'])->name ('course-watch');
//Route::get ('/course-single-enrolled/{slug?}', [User_CourseController::class,'ViewEnrolledCourse'])->name ('course-single-enrolled');









Route::get ('/subjects', [TopicsController::class,'ViewAll'])->name ('viewAllTopic');
Route::get ('/subject/{slug?}', [TopicsController::class,'ViewTopic'])->name ('viewTopic');



/*==== student ===*/
Route::group(['middleware'=> 'checkStudent'], function(){
    //Route::get ('/student-profile-dashboard', [StudentController::class,'loadDashboard'])->name('student-profile-dashboard');
});

Route::group(['prefix'=>'student','as'=>'student.'], function(){
    Route::get ('/my-profile', [StudentController::class,'viewMyProfile'])->name ('my-profile');
    Route::get ('/my-courses', [StudentController::class,'viewMyCourses'])->name ('my-courses');

    Route::get ('/help', [StudentController::class,'viewHelp'])->name ('help');
    Route::get ('/dashboard', [StudentController::class,'viewDashboard'])->name ('dashboard');
    Route::get ('/profile-edit', [StudentController::class,'profileEdit'])->name ('profile-edit');
    Route::get ('/{slug?}', [StudentController::class,'viewStudent'])->name ('view-profile');
    Route::get ('/{slug?}/courses', [StudentController::class,'viewEnrolledCourses'])->name('courses');
});


/*==== teacher ===*/
Route::group(['prefix'=>'teacher','as'=>'teacher.'], function(){
    Route::get ('/view-all', [TeacherController::class,'viewAllTeachers'])->name ('view-all');
    Route::get ('/my-profile', [TeacherController::class,'viewMyProfile'])->name ('my-profile');
    Route::get ('/my-courses', [TeacherController::class,'viewMyCourses'])->name ('my-courses');

    Route::get ('/earnings', [TeacherController::class,'ViewEarnings'])->name ('earnings');
    Route::get ('/dashboard', [TeacherController::class,'viewDashboard'])->name ('dashboard');
    Route::get ('/course-edit', [TeacherController::class,'courseAddContent'])->name ('course-add-content');
    Route::get ('/course-create', [TeacherController::class,'createCourse'])->name ('course-create');
    Route::get ('/profile-edit', [TeacherController::class,'profileEdit'])->name ('profile-edit');
    Route::get ('/instructions', [TeacherController::class,'viewInstruction'])->name ('instructions');
    Route::get ('/help', [TeacherController::class,'viewTeacherProfileHelp'])->name ('help');

    Route::get ('/{username?}', [TeacherController::class,'viewTeacher'])->name ('view-profile');
    //Route::get ('/{slug?}/courses', [TeacherController::class,'viewCourses'])->name('courses');

});



/*
Route::get ('/teacher/profile', [TeacherController::class,'viewProfile'])->name ('teacher-profile');
Route::get ('/teacher/earnings', [TeacherController::class,'ViewEarnings'])->name ('teacher-profile-earnings');
Route::get ('/teacher/dashboard', [TeacherController::class,'viewDashboard'])->name ('teacher-profile-dashboard');
Route::get ('/teacher/course-edit', [TeacherController::class,'courseAddContent'])->name ('teacher-profile-course-add-content');
Route::get ('/teacher/course-create', [TeacherController::class,'createCourse'])->name ('teacher-profile-course-create');
Route::get ('/teacher/profile-edit', [TeacherController::class,'profileEdit'])->name ('teacher-profile-edit');
Route::get ('/teacher-instruction', [TeacherController::class,'viewInstruction'])->name ('teacher-instruction');
Route::get ('/teacher-profile-help', [TeacherController::class,'viewTeacherProfileHelp'])->name ('teacher-profile-help');
Route::get ('/teacher/{username?}', [TeacherController::class,'viewTeacher'])->name ('teacher-profile-view');
Route::get ('/teacher/{slug?}/courses', [TeacherController::class,'viewCourses'])->name('teacher-profile-courses');
*/



Route::group(['prefix'=>'contact','as'=>'contact.','namespace' =>''], function(){
    Route::get ('/', [ContactController::class,'index'])->name ('index');
    Route::post('/store', [ContactController::class,'store'])->name ('store');
});




//Route::group(['middleware' => ['CheckIsAdminUser', 'CheckMarketer']], function() {
//
//});

//todo - apply adminpanelaccess middle ware to all pages(except admin.login,admin.login-submit)
Route::group(['prefix'=>'admin','as'=>'admin.'], function(){

    Route::group(['namespace'=>'Admin'], function(){

        

        Route::group(['namespace'=>'auth'], function(){
            //dump('ss');
            //Route::get ('', [Admin_LoginController::class,'adminLogin'])->name ('login');
            //Route::post ('', [Admin_LoginController::class,'adminLoginSubmit'])->name ('login-submit');
            //Route::post ('/change-password', [ChangeAdminPasswordController::class,'changePassword'])->name('changePassword');
        });

        Route::get('/settings', [SettingsController::class,'index'])->name ('settings');




        Route::group(['middleware'=> 'adminPanelAccess'], function(){
            
            Route::get('/dashboard', function () {
                //dump('ee');
                return view('admin-panel.dashboard');
            })->name('dashboard');
        });


        Route::group(['middleware' => ['canAccess:admin,editor']], function() {
            Route::get('/404', function () {
                return view('admin-panel.errors.404');
            })->name('404');

            Route::get('/500', function () {
                return view('admin-panel.errors.500');
            })->name('500');
        });




        Route::get('/11', function () {
            return view('admin-panel.11');
        })->name('admin11');



        Route::group(['prefix'=>'course','as'=>'course.'], function(){
            //Route::get ('/content', [Admin_CourseController::class,'courseContent'])->name ('content');
            

            Route::get ('/add-2', [Admin_CourseController::class,'addCourseCopy'])->name ('add-2');
            Route::post('/change-status', [Admin_CourseController::class,'changeStatus'])->name ('change-status');
            Route::get('/add0', function(){return view('admin-panel.course-add-backup1');})->name ('add0');
            Route::post('/check-empty', [Admin_CourseController::class,'checkEmpty'])->name ('check-empty');
        


        });

        Route::group(['prefix'=>'user','as'=>'user.'], function(){
            Route::get ('/approve-teachers', [UserController::class,'viewUnApprovedTeachersList'])->name ('un-approved-teachers-list');
            Route::get ('/approve-teachers/{id}', [UserController::class,'viewUnApprovedTeacher'])->name ('view-un-approved-teacher');
            

            Route::get ('/changes-approve', [UserController::class,'changesApprove'])->name ('changes-approve');

            Route::post ('/store-teacher', [UserController::class,'storeTeacher'])->name ('store-teacher');
            Route::post ('/store-student', [UserController::class,'storeStudent'])->name ('store-student');
            Route::post ('/store-marketer', [UserController::class,'storeMarketer'])->name ('store-marketer');
            Route::post ('/store-editor', [UserController::class,'storeEditor'])->name ('store-editor');

            Route::patch('/update-teacher/{id}', [UserController::class,'updateTeacher'])->name ('update-teacher');
            Route::patch('/update-student/{id}', [UserController::class,'updateStudent'])->name ('update-student');
            Route::patch('/update-marketer/{id}', [UserController::class,'updateMarketer'])->name ('update-marketer');
            Route::patch('/update-editor/{id}', [UserController::class,'updateEditor'])->name ('update-editor');

            Route::post('/change-status', [UserController::class,'changeStatus'])->name ('change-status');
        });


        Route::group(['prefix'=>'revenue','as'=>'revenue.'], function(){
            Route::get('/view-checkouts',function(){return view('admin-panel.admin.view-checkouts');})->name('checkouts');
            Route::get('/earnings',function(){return view('admin-panel.admin.earnings');})->name('all-earnings');
            
            Route::get('/course-earnings',function(){return view('admin-panel.admin.earnings-course');})->name('course-earnings');
            Route::get('/teacher-earnings',function(){return view('admin-panel.admin.earnings-teacher');})->name('teacher-earnings');
            Route::get('/teacher-salary',function(){return view('admin-panel.admin.teacher-salary');})->name('teacher-salary');
        });

        Route::group(['prefix'=>'salary','as'=>'salary.'], function(){
            Route::get('/pay-teacher',function(){return view('admin-panel.admin.salary-pay-teacher');})->name('pay-teacher');
            Route::get('/pay-marketer',function(){return view('admin-panel.admin.salary-pay-marketer');})->name('pay-marketer');
            Route::get('/salary-slip',function(){return view('admin-panel.salary-slip');})->name('salary-slip');
        });



        Route::group(['prefix'=>'cupon-code','as'=>'cupon-code.'], function(){
            Route::get('/add',function(){return view('admin-panel.admin.cupon-code-add');})->name('add');
            Route::get('/marketers',function(){return view('admin-panel.admin.cupon-code-list-marketers');})->name('marketers');
            Route::get('/teachers',function(){return view('admin-panel.admin.cupon-code-list-teachers');})->name('teachers');

            //Route::get('/courses',function(){return view('aadmin-panelcupon-code-courses');})->name('courses');
            //Route::get('/marketers',function(){return view('aadmin-panelcupon-code-marketers');})->name('marketers');

            Route::get('/view',function(){return view('admin-panel.marketer.list-cupon-codes');})->name('view');
            Route::get('/new',function(){return view('admin-panel.marketer.new-cupon-codes');})->name('new');
            Route::get('/usage',function(){return view('admin-panel.marketer.usage-cupon-codes');})->name('usage');
            Route::get('/dashboard',function(){return view('admin-panel.marketer.dashboard');})->name('dashboard');
            Route::get('/single',function(){return view('admin-panel.marketer.cupon-code-view');})->name('single');
        
            Route::get('/teacher-view',function(){return view('admin-panel.teacher.list-cupon-codes');})->name('teacher-view');
            
            Route::get ('/earnings', [Admin_MarketerController::class,'ViewEarnings'])->name ('earnings');
            Route::get ('/my-salary', [Admin_MarketerController::class,'viewMySalary'])->name ('my-salary');

        });

        Route::group(['prefix'=>'feedback','as'=>'feedback.'], function(){
            Route::get ('/students', [ContactUsMessagesController::class,'students'])->name ('students');
            Route::get ('/teachers', [ContactUsMessagesController::class,'teachers'])->name ('teachers');
            Route::get ('/other-users', [ContactUsMessagesController::class,'otherUsers'])->name ('other-users');
            Route::get ('/guests', [ContactUsMessagesController::class,'guests'])->name ('guests');
            Route::delete ('/{id}', [ContactUsMessagesController::class,'delete_comment'])->name ('delete_comment');
        });


        Route::group(['prefix'=>'teacher','as'=>'teacher.'], function(){            
            Route::get ('/my-courses', [Admin_TeacherController::class,'viewMyCourses'])->name ('my-courses');
            Route::get ('/earnings', [Admin_TeacherController::class,'ViewEarnings'])->name ('earnings');
            Route::get ('/dashboard', [Admin_TeacherController::class,'viewDashboard'])->name ('dashboard');
            Route::get ('/profile-edit', [Admin_TeacherController::class,'profileEdit'])->name ('profile-edit');
            
            Route::get ('/enrollments', [Admin_TeacherController::class,'viewCourseEnrollmentList'])->name ('enrollments');
            Route::get ('/completions', [Admin_TeacherController::class,'viewCourseCompleteList'])->name ('completions');
            
            Route::get ('/my-salary', [Admin_TeacherController::class,'viewMySalary'])->name ('my-salary');

        });



    });

    //Route::group(['middleware' => ['canAccess:admin,editor']], function() {
        Route::resource ('/subject', SubjectController::class);
    //});


    Route::group(['as'=>'course.'  ,'prefix'=>'course'],function(){
        Route::get('/enrollments', [Admin_CourseController::class,'viewCourseEnrollmentList'])->name ('enrollement-list');
        Route::get('/completions', [Admin_CourseController::class,'viewCourseCompleteList'])->name ('complete-list');       


        Route::resource('/', Admin_CourseController::class); 
    });    


    








    Route::resource('/user', UserController::class)->except(['store','update']);
});






//testing purpose
Route::group(['namespace'=>'Admin'], function(){
    Route::get ('/students', [User_ContactUsMessagesController::class,'students'])->name ('students');
});


//Route::fallback(function(){ return response()->view('errors.404', [], 404); });
Route::fallback([PageController::class,'page404']);