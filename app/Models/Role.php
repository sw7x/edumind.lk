<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
	
	const ADMIN 	= 'admin';
	const EDITOR 	= 'editor';
	const MARKETER 	= 'marketer';
	const TEACHER 	= 'teacher';
	const STUDENT 	= 'student';




}
