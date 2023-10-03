<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\EdumindRevenueService;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;
use App\View\DataTransformers\Admin\EdumindRevenueDataTransformer as AdminEdumindRevenueDataTransformer;

//use App\Models\Coupon;
//use Illuminate\Auth\Access\AuthorizationException;
//use Illuminate\Database\Eloquent\ModelNotFoundException;

class EdumindRevenueController extends Controller
{
    public function loadEarningsRecords(Request $request){

    }


    public function loadEarnings_0(Request $request){

        try{
            //todo
            //$this->authorize('create',Subject::class);

            $edumindRevenueData = (new EdumindRevenueService())->loadEarnings();
            $earningsData       =  AdminEdumindRevenueDataTransformer::prepareData($edumindRevenueData);

        }catch(CustomException $e){
            $earningsData = null;
            $request->session()->flash('message',  $e->getMessage());
            $request->session()->flash('cls',      'flash-danger');
            $request->session()->flash('msgTitle', 'Error !');
        }catch(\Exception $e){
            $earningsData = null;
            $request->session()->flash('message',  'Unable to load earnings!');
            $request->session()->flash('cls',      'flash-danger');
            $request->session()->flash('msgTitle', 'Error !');
        }
        return view('admin-panel.admin.earnings-0')->with(["data" => $earningsData]);
    }


    public function loadEarnings(Request $request){

        try{
            //todo
            //$this->authorize('create',Subject::class);

            //throw new CustomException('For example, to access a request parameter');

            $edumindRevenueData = (new EdumindRevenueService())->loadEarnings();
            $earningsData       =  AdminEdumindRevenueDataTransformer::prepareData($edumindRevenueData);
            return view('admin-panel.admin.earnings')->with(["data" => $earningsData]);

        }catch(CustomException $e){
            return view('admin-panel.admin.earnings')->with([
                'message'   => $e->getMessage(),
                'cls'       => 'flash-danger',
                'msgTitle'  => 'Error !',
            ]);
        }catch(\Exception $e){
            return view('admin-panel.admin.earnings')->with([
                //'message'  => $e->getMessage(),
                'message'   => 'Unable to load earnings!',//-----------------
                'cls'       => 'flash-danger',
                'msgTitle'  => 'Error !',
            ]);
        }
    }


}

/*
catch(AuthorizationException $e){
    return redirect(route('admin.subjects.create'))->with([
        'message'     => 'You dont have Permissions view earnings !',
        'cls'         => 'flash-danger',
        'msgTitle'    => 'Permission Denied !',
    ]);
}
*/
