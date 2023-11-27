<?php 

namespace App\Permissions\Abilities;

class AuthAbilities{

	const ACTIVATE 				 = 'activate';

	const CHANGE_PASSWORD 		 = 'change_password';

	const RESET_PASSWORD_REQUEST = 'reset_password_request';
	const RESET_PASSWORD_CONFIRM = 'reset_password_confirm';

	const LOGIN 				 = 'login';
	const LOGOUT 				 = 'logout';

	const STUDENT_REGISTER 		 = 'student_register';
	const TEACHER_REGISTER 		 = 'teacher_register';
}