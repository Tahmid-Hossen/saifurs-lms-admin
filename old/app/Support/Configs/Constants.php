<?php

namespace App\Support\Configs;

class Constants
{
    public static $user_default_status = 'IN-ACTIVE';
    public static $user_active_status = 'ACTIVE';
    public static $user_yellow_status = 'YELLOW';
    public static $user_block_status = 'BLOCK';

    public static $course_default_status = 'IN-ACTIVE';
    public static $course_active_status = 'ACTIVE';

    public static $course_default_featured = 'NO';
    public static $course_active_featured = 'YES';

    public static $course_default_assignment = 'NO';
    public static $course_active_assignment = 'YES';

    public static $course_default_certified = 'NO';
    public static $course_active_certified = 'YES';

    public static $course_default_subscribed = 'NO';
    public static $course_active_subscribed = 'YES';

    public static $course_default_language = 'EN';
    public static $course_ba_language = 'BA';
    public static $course_us_language = 'US';

    public static $course_pdf_format = 'PDF';
    public static $course_doc_format = 'DOC';
    public static $course_csv_format = 'CSV';

    public static $course_default_download = 'NO';
    public static $course_active_download = 'YES';

    public static $user_status = [
        'IN-ACTIVE',
        'ACTIVE'
    ];

    public static $course_status = [
        'INACTIVE',
        'ACTIVE'
    ];

    public static $chapter_status = [
        'INACTIVE',
        'ACTIVE',
    ];

    public static $class_status = [
        'INACTIVE',
        'ACTIVE',
    ];

    public static $question_status = [
        'INACTIVE',
        'ACTIVE',
    ];

    public static $answer_status = [
        'INACTIVE',
        'ACTIVE',
    ];

    public static $result_status = [
        'INACTIVE',
        'ACTIVE',
    ];

    public static $course_featured = [
        'NO',
        'YES',
    ];

    public static $chapter_featured = [
        'NO',
        'YES',
    ];

    public static $class_featured = [
        'NO',
        'YES',
    ];

    public static $question_featured = [
        'NO',
        'YES',
    ];

    public static $answer_featured = [
        'NO',
        'YES',
    ];

    public static $course_duration = [
        'Days',
        'Weeks',
        'Months',
    ];

    public static $course_types = [
        'free',
        'paid',
        'promo',
    ];

    public static $course_assignment = [
        '0',
        '1',
    ];

    public static $course_drip_content = [
        'Enable',
        'Disable',
    ];

    public static $course_class_drip_content = [
        'Enable',
        'Disable',
    ];

    public static $class_types = [
        'Offline',
        'Online',
    ];

    public static $course_language = [
        'ENGLISH',
        'BANGLA',
    ];

    public static $course_options = [
        'Live',
        'Recorded',
    ];


}
