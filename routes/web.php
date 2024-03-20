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

use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController as User_SubjectController;
use App\Http\Controllers\CourseController as User_CourseController;
use App\Http\Controllers\CartController;


use App\Http\Controllers\Admin\ContactUsMessagesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SubjectController as Admin_SubjectController;
use App\Http\Controllers\Admin\CourseController as Admin_CourseController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\TeacherController as Admin_TeacherController;
use App\Http\Controllers\Admin\MarketerController as Admin_MarketerController;
use App\Http\Controllers\Admin\EditorController as Admin_EditorController;
use App\Http\Controllers\Admin\AdminPanelController;
use App\Http\Controllers\Admin\EdumindRevenueController;




/*  ======  Artisan routes  -  /routes/web-includes/artisan-commands.php   ============== */

/*  ======  Auth routes     -  /routes/web-includes/auth.php               ============== */

/*  ======  Test routes     -  /routes/web-includes/test.php               ============== */




/*
//====== need later =====
Route::get('/courses-list',             function(){ return view('courses-list');})->name('courses-list');
Route::get('/search2',                  function(){ return view('search-2');})->name('search2');
Route::get('/page-privacy',             function(){ return view('privacy-policy-page');})->name('privacy-policy');
Route::get('/faq',                      function(){ return view('faq-page');})->name('faq');
Route::get('/0-course-watch',           function(){ return view('0-course-watch');})->name('0-course-watch');
Route::get('/admin/course-add-backup1', function(){ return view('admin-panel.course-add-backup1');})->name('admin.course-add-backup1');
Route::get('/admin/11',                 function(){ return view('admin-panel.11');})->name('admin.admin11');
Route::get('/admin/empty',              function(){ return view('admin-panel.empty');})->name('admin.empty');
Route::get('/admin/login-page',         function(){ return view('admin-panel.auth.-login-page');})->name('admin.login-page');
Route::get('/admin/sss',                function(){ return view('admin-panel.teacher.approve-account');})->name('admin.sss');
Route::get('/coursesx',                 function(){ return view('courses');})->name('coursesx');
*/



/*
//===== dev ============
Route::get('/form-submit-page', function(){ return view('form-submit-page');})->name('form-submit-page');
Route::get('/empty',            function(){ return view('empty');})->name('empty');
Route::get('/404',              function(){ return view('errors.404');})->name('404');
Route::get('/403',              function(){ return view('errors.403');})->name('403');
Route::get('/default-page',     function(){ return view('default-page');})->name('default-page');
*/



/*
Route::get('/', [HomeController::class,'index'])->name('home');
->middleware('can:view-any,App\Models\ContactUs');
->middleware('can:viewAny');
*/



//Route::get('/coming-soon', [PageController::class,'viewComingSoon'])->name('coming-soon');
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/about-us', [PageController::class,'viewAboutUs'])->name('about-us');
Route::get('/why-choose-us', [PageController::class,'viewWhyChooseUs'])->name('why-choose-us');
Route::get('/terms-and-services', [PageController::class,'viewTermsAndServices'])->name('terms-and-services');
Route::get('/instructions', [PageController::class,'viewInstruction'])->name('instructions');
Route::get('/help', [PageController::class,'viewHelp'])->name('help');



/* ========== common routes for users ============*/
Route::get('/profile', [PageController::class,'viewProfile'])->name('profile');
Route::get('/dashboard', [PageController::class,'viewDashboard'])->name('dashboard');
Route::get('/profile-edit', [PageController::class,'viewProfileEdit'])->name('profile-edit');
Route::get('/enrolled-courses', [StudentController::class,'enrolledCourses'])->name('enrolled-courses');





//------------>>>>>>>>>>>>>>>>>>>>>>>>>>
/* =========== cart =================*/
Route::get('/cart', [CartController::class,'viewCart'])->name('view-cart');
Route::get('/billing-info', [CartController::class,'loadBillingInfoForm'])->name('billing-info');
Route::post('/submit-billing-info', [CartController::class,'submitBillingInfo'])->name('submit-billing-info');
Route::get('/checkout', [CartController::class,'loadCheckout'])->name('load-checkout');
Route::post('/checkout', [CartController::class,'checkout'])->name('checkout');
//Route::get('/checkout-complete',function(){ return view('student.cart.checkout-complete');})->name('checkout-complete');
//Route::get('/payment-failed',function(){ return view('student.cart.payment-failed');})->name('payment-failed');




Route::post('/apply-coupon', [CartController::class,'applyCoupon'])->name('apply-coupon');
Route::post('/remove-coupon', [CartController::class,'removeCoupon'])->name('remove-coupon');
Route::post('/cart/remove/{id}', [CartController::class,'removeFromCart'])->name('remove-cart');
Route::post('/course/add-to-cart', [CartController::class,'addToCart'])->name('course.addToCart');

//Route::get('/credit-pay',function(){ return view('student.cart.pay-with-credit-card');})->name('credit-pay');
//Route::get('/bill-info',function(){ return view('student.cart.bill-info');})->name('bill-info');
/*======================================================*/












Route::group(['prefix'=>'courses','as'=>'courses.'], function(){
    Route::get('/', [User_CourseController::class,'index'])->name('index');
    Route::get('/guest-enroll', [User_CourseController::class,'guestEnroll'])->name('guest-enroll');
    Route::post('/free-enroll', [User_CourseController::class,'freeEnroll'])->name('free-enroll');
    Route::post('/complete', [User_CourseController::class,'complete'])->name('complete');

    Route::get('/search', [User_CourseController::class,'viewSearchPage'])->name('search');
    Route::post('/search', [User_CourseController::class,'submitSearch'])->name('search-submit');

    Route::get('/{slug?}', [User_CourseController::class,'show'])->name('show');
    Route::get('/watch/{slug?}/{videoId?}', [User_CourseController::class,'watchCourse'])->name('watch');
    //Route::get('/course-single-enrolled/{slug?}', [User_CourseController::class,'ViewEnrolledCourse'])->name('course-single-enrolled');
});






Route::group(['prefix'=>'subjects','as'=>'subjects.'], function(){
    Route::get('/', [User_SubjectController::class,'index'])->name('index');
    Route::get('/{slug?}', [User_SubjectController::class,'show'])->name('show');
});




/*==== student ===*/
//for testing later remove
    //block to other users than students
    Route::get('/student-profile-dashboard', [StudentController::class,'loadDashboard'])->name('student-profile-dashboard');



Route::group(['prefix'=>'students','as'=>'students.'], function(){
    Route::get('/{slug?}', [StudentController::class,'viewStudent'])->name('show');
    Route::get('/{slug?}/courses', [StudentController::class,'viewStudentEnrolledCourses'])->name('courses');
});


/*==== teacher ===*/
Route::group(['prefix'=>'teachers','as'=>'teachers.'], function(){
    Route::get('/', [TeacherController::class,'viewAllTeachers'])->name('index');
    //Route::get('/my-courses', [TeacherController::class,'viewMyCourses'])->name('my-courses');
    Route::get('/{username?}', [TeacherController::class,'viewTeacher'])->name('show');
    //Route::get('/{slug?}/courses', [TeacherController::class,'viewCourses'])->name('courses');
});


Route::group(['prefix'=>'contact-us','as'=>'contact-us.','namespace' =>''], function(){
    Route::get('/', [ContactUsController::class,'viewContactUs'])
    //->middleware('can:view_guest_messages_admin_panel, App\Models\ContactUs')
    ->name('view');    
    Route::post('/submit', [ContactUsController::class,'submitContactForm'])->name('submit');
});
//->can('create', ContactUs::class);;
            

/*
Route::group(['middleware' => ['___', '___']], function() {

});
*/




//todo - apply adminpanelaccess middle ware to all pages(except admin.login,admin.login-submit)
Route::group(['prefix'=>'admin','as'=>'admin.'], function(){

    Route::group(['namespace'=>'Admin'], function(){
           
        //todo---
        Route::group(['middleware' => 'adminPanelAccess'], function(){});
        Route::group(['middleware' => ['canAccess:admin,editor']], function() {
            Route::get('/404', function(){ return view('admin-panel.errors.404');})->name('404');
            Route::get('/500', function(){ return view('admin-panel.errors.500');})->name('500');
        });


        Route::get('/dashboard',[AdminPanelController::class,'viewDashboard'])->name('dashboard');
        Route::get('/profile', [AdminPanelController::class,'viewProfile'])->name('profile');
        Route::get('profile-edit', [AdminPanelController::class,'viewProfileEdit'])->name('profile-edit');
        Route::get('/my-courses', [Admin_TeacherController::class,'viewMyCourses'])->name('my-courses');
        Route::get('/my-earnings', [AdminPanelController::class,'ViewMyEarnings'])->name('my-earnings');
        Route::get('/my-commissions', [Admin_MarketerController::class,'viewMyCommissions'])->name('my-commissions');
        Route::get('/my-salaries', [Admin_TeacherController::class,'viewMySalaries'])->name('my-salaries');
        Route::get('/enrollments', [Admin_TeacherController::class,'viewCourseEnrollmentList'])->name('enrollments');
        Route::get('/course-completions', [Admin_TeacherController::class,'viewCourseCompleteList'])->name('course-completions');
            
        

        Route::get('teacher/my-earnings', [Admin_TeacherController::class,'ViewEarnings'])->name('teacher.my-earnings');
        Route::get('marketer/my-earnings', [Admin_MarketerController::class,'ViewMyEarnings'])->name('marketer.my-earnings');



        Route::group(['prefix'=>'users','as'=>'users.'], function(){
            Route::get('/approve-teachers', [UserController::class,'viewUnApprovedTeachersList'])->name('un-approved-teachers-list');
            Route::get('/approve-teachers/{id}', [UserController::class,'viewUnApprovedTeacher'])->name('view-un-approved-teacher');
            
            Route::get('/changes-approve', [UserController::class,'changesApprove'])->name('changes-approve');

            Route::post('/store-teacher', [UserController::class,'storeTeacher'])->name('store-teacher');
            Route::post('/store-student', [UserController::class,'storeStudent'])->name('store-student');
            Route::post('/store-marketer', [UserController::class,'storeMarketer'])->name('store-marketer');
            Route::post('/store-editor', [UserController::class,'storeEditor'])->name('store-editor');

            Route::patch('/update-teacher/{id}', [UserController::class,'updateTeacher'])->name('update-teacher');
            Route::patch('/update-student/{id}', [UserController::class,'updateStudent'])->name('update-student');
            Route::patch('/update-marketer/{id}', [UserController::class,'updateMarketer'])->name('update-marketer');
            Route::patch('/update-editor/{id}', [UserController::class,'updateEditor'])->name('update-editor');

            Route::post('/change-status', [UserController::class,'changeStatus'])->name('change-status');



            Route::post('/check-can-delete', [UserController::class,'checkCanDelete'])->name('check-can-delete');
            Route::get('/trashed', [UserController::class,'viewTrashedList'])->name('trashed');
            Route::patch('/restore/{id}', [UserController::class,'restoreRec'])->name('restore');
            Route::delete('/permanently-delete/{id}', [UserController::class,'permanentlyDelete'])->name('permanently-delete');
    


        });


        Route::group(['prefix'=>'revenue','as'=>'revenue.'], function(){
            Route::get('/view-checkouts',function(){return view('admin-panel.admin.view-checkouts');})->name('checkouts');
            
            //Route::get('/earnings',function(){return view('admin-panel.admin.earnings');})->name('all-earnings');
            Route::get('/earnings',[EdumindRevenueController::class,'loadEarnings'])->name('all-earnings');
            Route::post('/123earnings',[EdumindRevenueController::class,'loadEarningsRecords'])->name('all-earnings-records');

            Route::get('/course-earnings',function(){return view('admin-panel.admin.earnings-course');})->name('course-earnings');
            Route::get('/teacher-earnings',function(){return view('admin-panel.admin.earnings-teacher');})->name('teacher-earnings');
            Route::get('/teacher-salary',function(){return view('admin-panel.admin.teacher-salary');})->name('teacher-salary');
        
            //Route::get('/xxx',[EdumindRevenueController::class,'loadEarnings'])->name('xxx');
        });

        
        Route::group(['prefix'=>'salary','as'=>'salary.'], function(){
            Route::get('/pay-teacher',function(){return view('admin-panel.admin.salary-pay-teacher');})->name('pay-teacher');
            Route::get('/pay-marketer',function(){return view('admin-panel.admin.salary-pay-marketer');})->name('pay-marketer');
            Route::get('/teacher-salary-slip',function(){return view('admin-panel.salary-slip-teacher');})->name('teacher-salary-slip');
            Route::get('/marketer-salary-slip',function(){return view('admin-panel.salary-slip-marketer');})->name('marketer-salary-slip');
        });


        Route::group(['prefix'=>'coupon-codes','as'=>'coupon-codes.'], function(){
           
            Route::post('/generate-code', [CouponController::class,'generateCode'])->name('generate-code');
            Route::post('/beneficiaries', [CouponController::class,'fillBeneficiaries'])->name('load-beneficiaries');

            Route::get('/marketers',[CouponController::class,'loadMarketerCoupons'])->name('marketers');            
            Route::get('/teachers',[CouponController::class,'loadTeacherCoupons'])->name('teachers');
            //Route::get('/courses',function(){return view('aadmin-panelcoupon-code-courses');})->name('courses');
            //Route::get('/marketers',function(){return view('aadmin-panelcoupon-code-marketers');})->name('marketers');
            
            
            Route::get('/new',[CouponController::class,'newCoupons'])->name('new'); 
            Route::get('/usage',[CouponController::class,'usageOfCoupons'])->name('usage'); 
            //Route::get('/dashboard',function(){return view('admin-panel.marketer.dashboard');})->name('dashboard');

            
            Route::get('/my-coupons',[CouponController::class,'myCoupons'])->name('my-coupons');//TODO
        });
        
    

        Route::group(['prefix'=>'feedbacks','as'=>'feedbacks.'], function(){
            Route::get('/student', [ContactUsMessagesController::class,'viewStudentMessages'])->name('student');
            //->middleware('can:viewAny,App\Models\ContactUs');
            //->can('viewAny', ContactUs::class);
 
            Route::get('/teacher', [ContactUsMessagesController::class,'viewTeacherMessages'])->name('teacher');
            Route::get('/other-user', [ContactUsMessagesController::class,'viewOtherUserMessages'])->name('other-user');
            Route::get('/guest', [ContactUsMessagesController::class,'viewGuestMessages'])->name('guest');
            Route::delete('/{id}', [ContactUsMessagesController::class,'deleteComment'])->name('delete-comment');
        });


        Route::group(['prefix'=>'teacher','as'=>'teacher.'], function(){  
            //Route::get('/dashboard', [Admin_TeacherController::class,'viewDashboard'])->name('dashboard');
            //Route::get('/enrollments', [Admin_TeacherController::class,'viewCourseEnrollmentList'])->name('enrollments');
            //Route::get('/course-completions', [Admin_TeacherController::class,'viewCourseCompleteList'])->name('course-completions');
        });       


        Route::group(['prefix'=>'settings','as'=>'settings.'], function(){
            Route::get('/general', [SettingsController::class,'loadGeneralSettings'])->name('general');
            Route::get('/advanced', [SettingsController::class,'loadAdvancedSettings'])->name('advanced');
        });    

    });

    
    Route::group(['prefix'=>'subjects','as'=>'subjects.'], function(){
        Route::get('/trashed', [Admin_SubjectController::class,'viewTrashedList'])->name('trashed');
        Route::patch('/restore/{id}', [Admin_SubjectController::class,'restoreRec'])->name('restore');
        Route::delete('/permanently-delete/{id}', [Admin_SubjectController::class,'permanentlyDelete'])->name('permanently-delete');
    });
    //Route::group(['middleware' => ['canAccess:admin,editor']], function() {
        Route::resource('/subjects', Admin_SubjectController::class);
    //});

    

    /*
    Route::group(['prefix'=>'editor','as'=>'editor.'], function(){
        Route::get('/dashboard', [Admin_EditorController::class,'viewDashboard'])->name('dashboard');
    });
    */
    

    Route::group(['prefix'=>'courses','as'=>'courses.'], function(){
        Route::post('/change-status', [Admin_CourseController::class,'changeStatus'])->name('change-status');
        Route::post('/check-empty', [Admin_CourseController::class,'checkEmpty'])->name('check-empty');
        Route::post('/check-can-delete', [Admin_CourseController::class,'checkCanDelete'])->name('check-can-delete');

        Route::get('/enrollments', [Admin_CourseController::class,'viewCourseEnrollmentList'])->name('enrollement-list');
        Route::get('/completions', [Admin_CourseController::class,'viewCourseCompleteList'])->name('complete-list');       
    
        Route::get('/trashed', [Admin_CourseController::class,'viewTrashedList'])->name('trashed');
        Route::patch('/restore/{id}', [Admin_CourseController::class,'restoreRec'])->name('restore');
        Route::delete('/permanently-delete/{id}', [Admin_CourseController::class,'permanentlyDelete'])->name('permanently-delete');
    });
    Route::resource('/courses', Admin_CourseController::class);   
        
    Route::resource('/users', UserController::class)->except(['store','update']);

    Route::resource('/coupon-codes', CouponController::class)->except(['index', 'edit', 'update', 'destroy']);
});









//Route::fallback(function(){ return response()->view('errors.404', [], 404); });
Route::fallback([PageController::class,'page404']);
