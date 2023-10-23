<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\EdumindRevenueService;
use App\Http\Controllers\Controller;
use App\View\DataFormatters\Admin\EdumindRevenueDataFormatter as AdminEdumindRevenueDataFormatter;


class EdumindRevenueController extends Controller
{
    public function loadEarnings(Request $request){
        //todo
        //You dont have Permissions view earnings !
        //$this->authorize('create',Subject::class);

        $edumindRevenueData = (new EdumindRevenueService())->loadEarnings();
        $earningsData       =  AdminEdumindRevenueDataFormatter::prepareData($edumindRevenueData);
        return view('admin-panel.admin.earnings')->with(["data" => $earningsData]);
    }

}
