<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Coupon;
use Sentinel;
use App\Exceptions\CustomException;
use Illuminate\Support\Collection;


class CouponsController extends Controller
{
    public function create(){
    	

    	$courses = Course::Where('status',Course::PUBLISHED)->where('price','!=','0.00');

    	//dd($courses->pluck('name','id')->toArray());

    	$teachers   =   Sentinel::findRoleBySlug('teacher')->users()->with('roles')->where('status',1)->orderBy('id')->get();         
   		$marketers  =   Sentinel::findRoleBySlug('marketer')->users()->with('roles')->where('status',1)->orderBy('id')->get();

   		//dd($teachers->pluck('full_name','id')->toArray());



    	return view('admin-panel.admin.coupon-code-add')->with([
    		'courses' 	=> $courses->pluck('name','id')->toArray(),
			'teachers'	=> $teachers->pluck('full_name','id')->toArray(),
			'marketers' => $marketers->pluck('full_name','id')->toArray(),   		
    	]);
    }

   	public function generateCode(){
    	
    	try{         
            
			do{
				$genCode = strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));			
	    	}while(Coupon::find($genCode) != null);

			if($genCode){
				return response()->json([
	                'code'  => $genCode,
	                'status' => 'success',
	            ]);
	    	}else{
	    		throw new Exception("Coupon code generate failed!");
	    		
	    	}
          
        }catch(\Exception $e){
            return response()->json([
                'message'  	=> 'Coupon code generate failed!',
                'status' 	=> 'error',
            ]);
        }
    }



    public function loadBeneficiaries(Request $request){
    	
    	try{
	    	
	    	$courseId = $request->get('courseId');	    	

	    	if(!filter_var($courseId, FILTER_VALIDATE_INT) && $courseId != 0){
	            dd('courseId');
	            throw new CustomException('Invalid id');
	        }

	        //dd($request->get('courseId'));
	        //dump('courseId');
	        //dump($courseId);




			$marketers  =   Sentinel::findRoleBySlug('marketer')->users()->with('roles')->where('status',1)->orderBy('id')->get();
			
			if($courseId == 0){
				$teachers   =   Sentinel::findRoleBySlug('teacher')->users()->with('roles')->where('status',1)->orderBy('id')->get();
			}else{
				
				$course = Course::find($courseId);
		        if(!$course){
		        	throw new CustomException('Course not found in database');
		        }

	        	$authorId 	= $course->teacher->id;	
	        	//dump('authorId');
	        	//dump($authorId);

				$teachers   =   Sentinel::findRoleBySlug('teacher')
								->users()
								->with('roles')
								->where('status', 1)
								->where('id', $authorId)
								->orderBy('id')
								->get();
			}
			
			//$marketers = '';
			//dump($marketers->pluck('full_name','id')->toArray());
			//dump($teachers->pluck('full_name','id')->toArray());


			
			return response()->json([
                'marketers' => $marketers->pluck('full_name','id')->toArray(),
                'teachers'	=> $teachers->pluck('full_name','id')->toArray(),
                'status' 	=> 'success',
            ]);
	    
			


    	}catch(CustomException $e){
            return response()->json([            
                'message'  	=> $e->getMessage(),
                'status' 	=> 'error',
            ]);

        }catch(\Exception $e){
            return response()->json([
                'message'  	=> 'Beneficiaries loading failed!',
                'status' 	=> 'error',
            ]);
        }
	

    }




}
