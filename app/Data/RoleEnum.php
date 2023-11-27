<?php
namespace App\Data;

class RoleEnum {
    const ADMIN     = 'admin';
    const EDITOR    = 'editor';
    const MARKETER  = 'marketer';
    const TEACHER   = 'teacher';
    const STUDENT   = 'student';



    public static function getRole($role) {
        switch ($role) {
            case self::ADMIN:
                return 'Admin';
            case self::EDITOR:
                return 'Editor';
            case self::MARKETER:
                return 'Marketer';
            case self::TEACHER:
                return 'Teacher';
            case self::STUDENT:
                return 'Student';
            default:
                return 'Unknown';
        }
    }
}