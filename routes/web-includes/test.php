<?php 





use App\Models\Subject;
use App\Models\User;
//use Sentinel;
use App\Models\Contact_us;
use Illuminate\Support\Facades\DB;






Route::get('/test123', function () {
    
    $msg = Contact_us::find(1);
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
