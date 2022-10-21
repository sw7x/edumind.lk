<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Sentinel;

class PageController extends Controller
{
    public function page404(Request $request){

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([], 404);
        }else{


            if(Sentinel::check()){
                if(Sentinel::getUser()->roles()->first()->slug == 'student'){
                    $view = 'errors.404' ;
                }else{
                    $view = $request->is('admin/*') ? 'admin-panel.errors.404' : 'errors.404' ;
                }

            }else{
                $view = 'errors.404' ;
            }


            return response()->view($view, [], 404);
        }
    }



    public function pageNoPermission(Request $request){

        //dump($request->input('susa'));
        //dd(Session::get('susa'));

        return view('form-submit-page');

        /*return view('form-submit-page')->with([
            //'message'     => 'You dont have permission to access this page',
            'message'     => $request->get('susa'),
            'cls'         => "flash-warning",
            'msgTitle'    => 'Warning !',
        ]);*/
    }


}
