<?php 

namespace App\Permissions\Abilities;

class UserManageAbilities{

	const ADMIN_PANEL_VIEW_USER_LIST = 'admin_panel_view_user_list';
	
	const ADMIN_PANEL_VIEW_USER 	 = 'admin_panel_view_user';
	const VIEW_TEACHERS 			 = 'admin_panel_view_teachers';
	const VIEW_STUDENTS 			 = 'admin_panel_view_students';
	const VIEW_MARKETERS 			 = 'admin_panel_view_editors';
	const VIEW_EDITORS 				 = 'admin_panel_view_marketers';

	
	const VIEW_CREATE_PAGE			 = 'admin_panel_view_create_users_page';
	const CREATE_TEACHERS 		 	 = 'admin_panel_create_teachers';
	const CREATE_STUDENTS 		 	 = 'admin_panel_create_students';
	const CREATE_MARKETERS 		 	 = 'admin_panel_create_marketers';
	const CREATE_EDITORS 		 	 = 'admin_panel_create_editors';


	const VIEW_EDIT_PAGE 		 	 = 'admin_panel_view_edit_users_page';
	const EDIT_TEACHERS 		 	 = 'admin_panel_edit_teachers';
	const EDIT_STUDENTS 		 	 = 'admin_panel_edit_students';
	const EDIT_MARKETERS 		 	 = 'admin_panel_edit_marketers';
	const EDIT_EDITORS 			 	 = 'admin_panel_edit_editors';


	const DELETE_USERS 			 	 = 'admin_panel_delete_users';
	const CHANGE_USERS_STATUS 	 	 = 'admin_panel_change_users_status';
}	




