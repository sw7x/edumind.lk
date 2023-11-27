<?php 

namespace App\Permissions\Abilities;

class ContactUsAbilities{

	const VIEW_PAGE   				= 'view_contact_page';
	const SUBMIT_FORM 				= 'submit_contact_form';

	const VIEW_GUEST_MESSAGES 		= 'admin_panel_view_guest_messages';
	const VIEW_STUDENT_MESSAGES 	= 'admin_panel_view_student_messages';
	const VIEW_TEACHER_MESSAGES	 	= 'admin_panel_view_teacher_messages';
	const VIEW_OTHER_USER_MESSAGES 	= 'admin_panel_view_other_user_messages';

	const DELETE_CONTACT_MESSAGES 	= 'admin_panel_delete_contact_messages';	

}