<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketerController extends Controller
{
    


    public function ViewEarnings(){
    	return view('admin-panel.marketer.my-earnings');
    }


    
    public function viewMySalary(){
        return view('admin-panel.marketer.my-salary');
    } 





}
