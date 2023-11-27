<?php 

namespace App\Permissions\Abilities;

class CourseAbilities{

	const ADMIN_PANEL_VIEW_COURSE_LIST 		= 'admin_panel_view_course_list';
	const ADMIN_PANEL_VIEW_COURSE 			= 'admin_panel_view_course';
	const CREATE_COURSES 					= 'admin_panel_create_courses';
	const EDIT_COURSE 						= 'admin_panel_edit_course';
	const DELETE_COURSE 					= 'admin_panel_delete_course';
	const CHANGE_COURSE_STATUS 				= 'admin_panel_change_course_status';

	const WATCH_COURSE						= 'watch_course';
	const ENROLL_TO_COURSE					= 'enroll_to_course';		
	const MARK_COMPLETE 					= 'mark_complete';
}