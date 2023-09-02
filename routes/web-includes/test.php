<?php 





use App\Models\Subject;
use App\Models\User;
//use Sentinel;
use App\Models\ContactUs;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\TestingController;





Route::get('/test123', function () {


    
    $msg = ContactUs::find(1);
    $user = Sentinel::getUser();
        

    dd($user->can('view', $msg));



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





Route::get ('/test/all', [TestingController::class,'all'])->name ('test.all');

Route::get ('/test/coupon', [TestingController::class,'coupon'])->name ('test.coupon');
Route::get ('/test/commission', [TestingController::class,'commission'])->name ('test.commission');
Route::get ('/test/authorSalary', [TestingController::class,'authorSalary'])->name ('test.authorSalary');
Route::get ('/test/course', [TestingController::class,'course'])->name ('test.course');
Route::get ('/test/contactUs', [TestingController::class,'contactUs'])->name ('test.contactUs');

Route::get ('/test/courseItem', [TestingController::class,'courseItem'])->name ('test.courseItem');
Route::get ('/test/enrollment', [TestingController::class,'enrollment'])->name ('test.enrollment');
Route::get ('/test/order', [TestingController::class,'order'])->name ('test.order');
Route::get ('/test/subject', [TestingController::class,'subject'])->name ('test.subject');


Route::get ('/test/user', [TestingController::class,'user'])->name ('test.user');

Route::get ('/test/user-admin', [TestingController::class,'userAdmin'])->name ('test.user-admin');
Route::get ('/test/user-editor', [TestingController::class,'userEditor'])->name ('test.user-editor');
Route::get ('/test/user-marketer', [TestingController::class,'userMarketer'])->name ('test.user-marketer');
Route::get ('/test/user-teacher', [TestingController::class,'userTeacher'])->name ('test.user-teacher');
Route::get ('/test/user-student', [TestingController::class,'userStudent'])->name ('test.user-student');
