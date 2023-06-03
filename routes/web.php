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


use App\Http\Controllers\Admin\ContactUsMessagesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SubjectController as Admin_SubjectController;

use App\Http\Controllers\Admin\CourseController as Admin_CourseController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Admin\TeacherController as Admin_TeacherController;
use App\Http\Controllers\Admin\MarketerController as Admin_MarketerController;
use App\Http\Controllers\Admin\EditorController as Admin_EditorController;
use App\Http\Controllers\Admin\AdminPanelController;
use App\Http\Controllers\SubjectController as User_SubjectController;
use App\Http\Controllers\CourseController as User_CourseController;
use App\Http\Controllers\CartController;















/*  ======  Artisan routes  -  /routes/web-includes/artisan-commands.php   ============== */


/*  ======  Auth routes     -  /routes/web-includes/auth.php               ============== */


/*  ======  Test routes     -  /routes/web-includes/test.php               ============== */






Route::get('/form-submit-page', function () {    return view('form-submit-page');})->name('form-submit-page');
Route::get('/coming-soon', function () {    return view('coming-soon');})->name('coming-soon');

Route::get ('/', [HomeController::class,'index'])
->name ('home');
//->middleware('can:view-any,App\Models\Contact_us');
//->middleware('can:viewAny');





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

Route::get('/empty',function(){ return view('empty');})->name('empty');
Route::get('/help',function(){ return view('help-page');})->name('help');


Route::get ('/all-courses', [User_CourseController::class,'viewAllCourses'])->name ('all-courses');



/* =========== cart =================*/

Route::get ('/cart', [CartController::class,'viewCart'])
->middleware('checkStudent')
->name('view-cart');




Route::get ('/billing-info', [CartController::class,'loadBillingInfoPage'])
->middleware('checkStudent')
->name('billing-info');

Route::post ('/submit-billing-info', [CartController::class,'submitBillingInfo'])
->middleware('checkStudent')
->name('submit-billing-info');




Route::post('/checkout', [CartController::class,'checkout'])
->middleware('checkStudent')
->name('checkout');

Route::get('/checkout-complete',function(){ return view('student.cart.checkout-complete');})->name('checkout-complete');

Route::get('/payment-failed',function(){ return view('student.cart.payment-failed');})->name('payment-failed');








Route::post('/apply-coupon', [CartController::class,'applyCoupon'])
->middleware('checkStudent')
->name('apply-coupon');


Route::post('/remove-coupon', [CartController::class,'removeCoupon'])
->middleware('checkStudent')
->name('remove-coupon');



Route::post ('/cart/remove/{id}', [CartController::class,'removeFromCart'])->middleware('checkStudent')->name('remove-cart');

Route::post ('/course/add-to-cart', [CartController::class,'addToCart'])->name ('course.addToCart');



//Route::get('/credit-pay',function(){ return view('student.cart.pay-with-credit-card');})->name('credit-pay');
//Route::get('/bill-info',function(){ return view('student.cart.bill-info');})->name('bill-info');


/*======================================================*/










Route::get('/terms-and-services',function(){ return view('terms-and-services');})->name('terms-and-services');
Route::get('/courses',function(){ return view('courses');})->name('courses');




Route::get('/test',function(){ return view('test');})->name('test');

//Route::get('/course-watch', function () {     return view('course-watch'); })->name('course-watch');
Route::get ('/course/guest-enroll', [User_CourseController::class,'guestEnroll'])->name ('course-guest-enroll');
Route::post ('/course/free-enroll', [User_CourseController::class,'freeEnroll'])->name ('course.free-enroll');




Route::post ('/course/complete', [User_CourseController::class,'complete'])->name ('course.complete');







Route::get('/course/search', [User_CourseController::class,'viewSearchPage'])->name ('course-search');
Route::post('/course/search', [User_CourseController::class,'SearchCourse'])->name ('course-search-submit');


Route::get ('/course/{slug?}', [User_CourseController::class,'ViewCourse'])->name('course-single');
Route::get ('/course/watch/{slug?}/{videoId?}', [User_CourseController::class,'watchCourse'])->name ('course-watch');
//Route::get ('/course-single-enrolled/{slug?}', [User_CourseController::class,'ViewEnrolledCourse'])->name ('course-single-enrolled');















Route::get ('/subjects', [User_SubjectController::class,'ViewAll'])->name ('viewAllTopic');
Route::get ('/subject/{slug?}', [User_SubjectController::class,'ViewTopic'])->name ('viewTopic');



/*==== student ===*/
Route::group(['middleware'=> 'checkStudent'], function(){
    //block to other users than students
    Route::get ('/student-profile-dashboard', [StudentController::class,'loadDashboard'])->name('student-profile-dashboard');
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
    
    //todo-delete
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
    Route::get ('/', [ContactUsController::class,'index'])->name ('index');
    Route::post('/store', [ContactUsController::class,'store'])->name ('store');
});




//Route::group(['middleware' => ['CheckIsAdminUser', 'CheckMarketer']], function() {
//
//});

//todo - apply adminpanelaccess middle ware to all pages(except admin.login,admin.login-submit)
Route::group(['prefix'=>'admin','as'=>'admin.'], function(){

    Route::group(['namespace'=>'Admin'], function(){

                
        Route::group(['prefix'=>'settings','as'=>'settings.'], function(){
            Route::get('/general', [SettingsController::class,'loadGeneralSettings'])->name ('general');
            Route::get('/advanced', [SettingsController::class,'loadAdvancedSettings'])->name ('advanced');
        });
              


        //todo---
        Route::group(['middleware'=> 'adminPanelAccess'], function(){});
            
        Route::get('/dashboard',[AdminPanelController::class,'viewDashboard'])->name('dashboard');
        


        Route::group(['middleware' => ['canAccess:admin,editor']], function() {
            Route::get('/404', function () {
                return view('admin-panel.errors.404');
            })->name('404');

            Route::get('/500', function () {
                return view('admin-panel.errors.500');
            })->name('500');
        });



        /* testing routes*/
        Route::get('/11', function () {return view('admin-panel.11');})->name('admin11');
        Route::get('/empty', function () {return view('admin-panel.empty');})->name('empty');



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
            Route::get('/teacher-salary-slip',function(){return view('admin-panel.salary-slip-teacher');})->name('teacher-salary-slip');
            Route::get('/marketer-salary-slip',function(){return view('admin-panel.salary-slip-marketer');})->name('marketer-salary-slip');
        
        });


        Route::group(['prefix'=>'coupon-code','as'=>'coupon-code.'], function(){
           
            Route::post ('/generate-code', [CouponController::class,'generateCode'])->name('generate-code');
            Route::post ('/beneficiaries', [CouponController::class,'loadBeneficiaries'])->name('load-beneficiaries');

            Route::get('/marketers',[CouponController::class,'loadMarketerCoupons'])->name('marketers');            
            Route::get('/teachers',[CouponController::class,'loadTeacherCoupons'])->name('teachers');
            //Route::get('/courses',function(){return view('aadmin-panelcoupon-code-courses');})->name('courses');
            //Route::get('/marketers',function(){return view('aadmin-panelcoupon-code-marketers');})->name('marketers');
            
            
            Route::get('/new',[CouponController::class,'newCoupons'])->name('new'); 
            Route::get('/usage',[CouponController::class,'usageOfCoupons'])->name('usage'); 
            //Route::get('/dashboard',function(){return view('admin-panel.marketer.dashboard');})->name('dashboard');

            Route::get('/my-coupons--t',[CouponController::class,'myCoupons__t'])->name('my-coupons--t');//TODO
            Route::get('/my-coupons--m',[CouponController::class,'myCoupons__m'])->name('my-coupons--m');//TODO
        });
        

        Route::group(['prefix'=>'feedback','as'=>'feedback.'], function(){
            Route::get ('/students', [ContactUsMessagesController::class,'students'])
            ->name ('students');
            //->middleware('can:viewAny,App\Models\Contact_us');
            //->can('viewAny', Contact_us::class);

            Route::get ('/teachers', [ContactUsMessagesController::class,'teachers'])->name ('teachers');
            Route::get ('/other-users', [ContactUsMessagesController::class,'otherUsers'])->name ('other-users');
            Route::get ('/guests', [ContactUsMessagesController::class,'guests'])->name ('guests');
            Route::delete ('/{id}', [ContactUsMessagesController::class,'delete_comment'])->name ('delete_comment');
        });


        Route::group(['prefix'=>'teacher','as'=>'teacher.'], function(){            
            Route::get ('/my-courses', [Admin_TeacherController::class,'viewMyCourses'])->name ('my-courses');
            Route::get ('/my-earnings', [Admin_TeacherController::class,'ViewEarnings'])->name ('my-earnings');
            //Route::get ('/dashboard', [Admin_TeacherController::class,'viewDashboard'])->name ('dashboard');
            Route::get ('/my-profile-edit', [Admin_TeacherController::class,'myProfileEdit'])->name ('my-profile-edit');
            
            Route::get ('/enrollments', [Admin_TeacherController::class,'viewCourseEnrollmentList'])->name ('enrollments');
            Route::get ('/course-completions', [Admin_TeacherController::class,'viewCourseCompleteList'])->name ('completions');
            
            Route::get ('/my-salaries', [Admin_TeacherController::class,'viewMySalaries'])->name ('my-salaries');

        });


        Route::group(['prefix'=>'marketer','as'=>'marketer.'], function(){
            Route::get ('/my-commissions', [Admin_MarketerController::class,'viewMyCommissions'])->name ('my-commissions');
            Route::get ('/my-earnings', [Admin_MarketerController::class,'ViewMyEarnings'])->name ('my-earnings');
        });    



    });

    

    //Route::group(['middleware' => ['canAccess:admin,editor']], function() {
        Route::resource ('/subject', Admin_SubjectController::class);
    //});
    
    

    /*Route::group(['prefix'=>'editor','as'=>'editor.'], function(){
        Route::get ('/dashboard', [Admin_EditorController::class,'viewDashboard'])->name ('dashboard');
    });*/

    

    /**/
    Route::group(['prefix'=>'course','as'=>'course.'], function(){
        //Route::get ('/content', [Admin_CourseController::class,'courseContent'])->name ('content');
        
        Route::get ('/add-2', [Admin_CourseController::class,'addCourseCopy'])->name ('add-2');
        Route::post('/change-status', [Admin_CourseController::class,'changeStatus'])->name ('change-status');
        Route::get('/add0', function(){return view('admin-panel.course-add-backup1');})->name ('add0');
        Route::post('/check-empty', [Admin_CourseController::class,'checkEmpty'])->name ('check-empty');
        
        Route::get('/enrollments', [Admin_CourseController::class,'viewCourseEnrollmentList'])->name ('enrollement-list');
        Route::get('/completions', [Admin_CourseController::class,'viewCourseCompleteList'])->name ('complete-list');       
    
    });
    Route::resource('/course', Admin_CourseController::class);   
        
    Route::resource('/user', UserController::class)->except(['store','update']);

    Route::resource('/coupon-code', CouponController::class)->except(['edit', 'update','index']);


});









//Route::fallback(function(){ return response()->view('errors.404', [], 404); });
Route::fallback([PageController::class,'page404']);