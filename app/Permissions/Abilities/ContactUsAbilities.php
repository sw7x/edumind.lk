<?php 

namespace App\Permissions\Abilities;

class ContactUsAbilities{

	const VIEW_PAGE   							 = 'view_page';
	const SUBMIT_FORM 							 = 'submit_form';

	const VIEW_ADMIN_PANEL_GUEST_MESSAGES 		 = 'view_admin_panel_guest_messages';
	const VIEW_ADMIN_PANEL_STUDENT_MESSAGES 	 = 'view_admin_panel_student_messages';
	const VIEW_ADMIN_PANEL_TEACHER_MESSAGES 	 = 'view_admin_panel_teacher_messages';
	const VIEW_ADMIN_PANEL_OTHER_USER_MESSAGES 	 = 'view_admin_panel_other_user_messages';

	const DELETE_MESSAGES 	 					 = 'delete_messages';	

	const TEST 	 					 			 = 'test';

}