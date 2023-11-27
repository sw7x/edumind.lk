<?php 

namespace App\Permissions\Abilities;

class CouponAbilities{

	const CREATE_COUPONS 				= 'admin_panel_create_coupons';

	const VIEW_MARKETER_COUPON_LIST 	= 'admin_panel_view_marketer_coupon_list';
	const VIEW_MARKETER_COUPON 			= 'admin_panel_view_marketer_coupon';
	//const EDIT_MARKETER_COUPON 		= 'admin_panel_edit_marketer_coupon';
	const DELETE_MARKETER_COUPON 		= 'admin_panel_delete_marketer_coupon';
	const CHANGE_MARKETER_COUPON_STATUS = 'admin_panel_change_marketer_coupon_status';

	
	const VIEW_TEACHER_COUPON_LIST 		= 'admin_panel_view_teacher_coupon_list';
	const VIEW_TEACHER_COUPON 			= 'admin_panel_view_teacher_coupon';
	//const EDIT_TEACHER_COUPON 		= 'admin_panel_edit_teacher_coupon';
	const DELETE_TEACHER_COUPON 		= 'admin_panel_delete_teacher_coupon';
	const CHANGE_TEACHER_COUPON_STATUS 	= 'admin_panel_change_teacher_coupon_status';


	const ADMIN_PANEL_VIEW_COUPON 					= 'admin_panel_view_coupon';
	const ADMIN_PANEL_VIEW_COUPON_USAGE_SECTION 	= 'admin_panel_view_coupon_usage_section';

	const ADMIN_PANEL_VIEW_NEW_COUPONS 				= 'admin_panel_view_new_coupons';
	const ADMIN_PANEL_VIEW_USED_COUPONS 			= 'admin_panel_view_used_coupons';
}