<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketerController extends Controller
{
    public function ViewMyEarnings(){
    	return view('admin-panel.marketer.my-earnings');
    }

    public function viewMyCommissions(){
        return view('admin-panel.marketer.my-commissions');
    }

}
