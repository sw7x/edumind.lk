<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sentinel;

use Illuminate\Support\Facades\Auth;

class AdminPanelController extends Controller
{
    

	public function viewDashboard(){
    	
		//dd(auth()->user());



		if(sentinel::check()){
            $userRole = Sentinel::getUser()->roles()->first()->slug;

            if($userRole == 'student'){
                
                /*return redirect(route('no-permission'))->with([
                    'message'     => 'You dont have permission to access this page',
                    'cls'         => "flash-warning",
                    'msgTitle'    => 'Warning !',
                ]);*/
                abort(403);

            }else if($userRole == 'admin'){                
               return view('admin-panel.admin.dashboard');
            }else if($userRole == 'editor'){
				return view('admin-panel.editor.dashboard');
            }else if($userRole == 'marketer'){
            	return view('admin-panel.marketer.dashboard');		
            }else if($userRole == 'teacher'){
            	return view('admin-panel.teacher.dashboard');	
            }else{
            	abort(403);	
            }

        }else{

        	return redirect(route('auth.login'))->with([
                'message'     => 'You dont have permission to access this page',
                'cls'         => "flash-warning",
                'msgTitle'    => 'Warning !',
            ]);
        }
     	
    }



}
