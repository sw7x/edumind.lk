<?php
namespace App\Data;

class CourseStatusEnum{

    const PUBLISHED = 'published';
    const DRAFT     = 'draft';

    public static function getStatus($status) {
        switch ($status) {
            case self::PUBLISHED:
                return 'Published';
            case self::DRAFT:
                return 'Draft';
            default:
                return 'Unknown';
        }
    }

}
