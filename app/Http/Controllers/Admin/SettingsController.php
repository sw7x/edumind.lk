<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request){
        return view('admin-panel.admin.settings')->with([
            'title' => 'Settings'
        ]);
    }



	public function loadGeneralSettings(){
		return view('admin-panel.admin.settings-general');
	}


	public function loadAdvancedSettings(){
		return view('admin-panel.admin.settings-advanced');
	}



}
