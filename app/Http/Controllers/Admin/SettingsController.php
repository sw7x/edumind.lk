<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Permissions\Abilities\SettingsAbilities;
use App\Permissions\Traits\PermissionCheck;

class SettingsController extends Controller
{
    use PermissionCheck;

	public function index(Request $request){
        return view('admin-panel.admin.settings')->with([
            'title' => 'Settings'
        ]);
    }

	public function loadGeneralSettings(){
		$this->hasPermission(SettingsAbilities::VIEW_GENERAL_SETTINGS);
		return view('admin-panel.admin.settings-general');
	}


	public function loadAdvancedSettings(){
		$this->hasPermission(SettingsAbilities::VIEW_ADVANCED_SETTINGS);
		return view('admin-panel.admin.settings-advanced');
	}


	//SettingsAbilities::UPDATE_GENERAL_SETTINGS        
	//SettingsAbilities::UPDATE_ADVANCED_SETTINGS

}


        

