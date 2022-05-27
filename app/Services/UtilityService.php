<?php

namespace App\Services;

use Carbon\Carbon;

/**
 * Class UtilityService
 * @package App\Services
 */
class UtilityService
{

    const SUPER_ADMIN = 'System Administrator';
    #const SUPER_ADMIN = 'Super Admin';

    /**
     * @var string
     */
    public static $numberOfMonthYear = '-5 month';
    /**
     * @var int
     */
    public static $displayRecordPerPage = 12;
    /**
     * @var int
     */
    public static $displayRecordPerPageForTransaction = 10000;
    /**
     * @var string[]
     */
    public static $working_days = ['saturday' => 'Saturday', 'sunday' => 'Sunday', 'monday' => 'Monday', 'tuesday' => 'Tuesday', 'wednesday' => 'Wednesday', 'thursday' => 'Thursday', 'friday' => 'Friday'];
    public static $months = ['' => 'Select a Month', '1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];
    public static $shortMonths = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];
    public static $working_status = ['' => 'Select Status', '1' => 'Full Time', '2' => 'Part Time', '3' => 'Casual', '4' => 'Inactive'];
    public static $siteSettings = ['vat' => 'Vat', 'service_charge' => 'Service Charge'];
    public static $marriedStatus = ['married' => 'Married', 'widowed' => 'Widowed', 'separated' => 'Separated', 'divorced' => 'Divorced', 'single' => 'Single'];
    public static $displayRecordPerPageSelect = ['10' => 10, '20' => 20, '50' => 50, '100' => 100, 'all' => 'All'];
    public static $ratingStarGroup = ['5_Star' => 0, '4_Star' => 0, '3_Star' => 0, '2_Star' => 0, '1_Star' => 0];
    public static $login_method = 1; //0=email, 1=username, 2=mobile_number
    public static $delete_method = 1; //0=no check, 1=auth check
    public static $role_method = 2; //1=multiply, 2=single
    public static $fileUploadPath = '';
    public static $ebookUploadPath = '/upload/ebook/';
    public static $pdfUploadPath = '/upload/images/book_thumbnail/pdf/';
    public static $currencyList = ['BDT' => 'Bangladeshi Taka', 'USD' => 'United States Dollar'];
    public static $languageList = ['1' => 'English', '2' => 'Bangla'];
    public static $paymentStates = ['full' => 'Full Paid', 'paid' => 'Full Paid', 'partial' => 'Partial Paid', 'due' => 'Due', 'unpaid' => 'Pending'];
    public static $discountTypes = ['fixed' => 'Fixed', 'percent' => 'Percentage'];
    public static $RegExUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

    /**
     * @var string[]
     */
    public static $colorList = [
        '01' => 'bg-light-blue-active',
        '02' => 'bg-aqua-active',
        '03' => 'bg-green-active',
        '04' => 'bg-yellow-active',
        '05' => 'bg-red-active',
        '06' => 'bg-gray-active',
        '07' => 'bg-navy-active',
        '08' => 'bg-teal-active',
        '09' => 'bg-purple-active',
        '10' => 'bg-orange-active',
        '11' => 'bg-maroon-active',
        '12' => 'bg-black-active',
        '13' => 'bg-light-blue',
        '14' => 'bg-aqua',
        '15' => 'bg-green',
        '16' => 'bg-yellow',
        '17' => 'bg-red',
        '18' => 'bg-gray',
        '19' => 'bg-navy',
        '20' => 'bg-teal',
        '21' => 'bg-purple',
        '22' => 'bg-orange',
        '23' => 'bg-maroon',
        '24' => 'bg-black',
        '25' => 'bg-light-blue disabled',
        '26' => 'bg-aqua disabled',
        '27' => 'bg-yellow disabled',
        '28' => 'bg-red disabled',
        '29' => 'bg-gray disabled',
        '30' => 'bg-navy disabled',
        '31' => 'bg-teal disabled',
    ];

    public static $colorCodeList = [
        '01' => '#357ca5',
        '02' => '#00a7d0',
        '03' => '#008d4c',
        '04' => '#db8b0b',
        '05' => '#d33724',
        '06' => '#b5bbc8',
        '07' => '#001a35',
        '08' => '#30bbbb',
        '09' => '#555299',
        '10' => '#ff7701',
        '11' => '#ca195a',
        '12' => '#000',
        '13' => '#3c8dbc',
        '14' => '#00c0ef',
        '15' => '#00a65a',
        '16' => '#f39c12',
        '17' => '#dd4b39',
        '18' => '#d2d6de',
        '19' => '#001f3f',
        '20' => '#39cccc',
        '21' => '#605ca8',
        '22' => '#ff851b',
        '23' => '#d81b60',
        '24' => '#111',
        '25' => '#3c8dbc', //bg-light-blue disabled
        '26' => '#00c0ef', //bg-aqua disabled
        '27' => '#00a65a', //bg-yellow disabled
        '28' => '#f39c12', //bg-red disabled
        '29' => '#dd4b39', //bg-gray disabled
        '30' => '#d2d6de', //bg-navy disabled
        '31' => '#001f3f', //bg-teal disabled
    ];

    public static $iconList = [
        'generation_update' => 'fa fa-sitemap',
        'username' => 'fa fa-user bg-aqua',
        'email' => 'fa fa-envelope bg-blue',
        'sponsor_id' => 'fa fa-users bg-red',
        'password' => 'fa fa-key bg-red',
        'member_image' => 'fa fa-camera bg-purple',
        'nominee_image' => 'fa fa-camera bg-maroon',
        'signature_image' => 'fa fa-camera bg-pink',
        'designation_update' => 'fa fa-odnoklassniki bg-green',
        'designation_global' => 'fa fa-share-alt bg-yellow',
        'designation_group' => 'fa fa-share-alt bg-yellow',
        'sign_up' => 'fa fa-user-plus bg-green',
        'generation' => 'fa fa-share-alt bg-yellow',
        'ip_transfer' => 'fa fa-exchange bg-green',
        'ip_approved' => 'fa fa-check-square-o bg-blue',
        '' => 'fa fa-cogs',
    ];
    /**
     * @var string[]
     */
    public static $announcementType = [
        'assignment' => 'Assignment',
        'general' => 'General'
    ];

    public static $yesNoStatus = [
        1 => 'Yes',
        0 => 'No',
        '' => 'No',
    ];

    public static $statusText = [
        'ACTIVE',
        'IN-ACTIVE',
    ];

    public static $featuredStatusText = [
        'NO',
        'YES',
    ];

    public static $approvedStatus = [
        'YES',
        'NO',
    ];

    public static $statusTextApproved = [
        'NOT-APPROVED',
        'APPROVED',
    ];

    public static $fieldType = [
        'username',
        'sign_up',
        'generation_update',
        'sponsor_id',
        'email',
        'password',
        'member_image',
        'nominee_image',
        'signature_image',
    ];

    public static $eventType = [
        'review' => 'Book Review',
        'announcement' => 'Course Announcement',
    ];

    public static $eventFeatured = [
        'YES' => 'Featured',
        'NO' => 'Non-Featured',
    ];

    public static $eventStatus = [
        'ACTIVE',
        'INACTIVE',
    ];

    public static $imageUploadPath = [
        'company_logo' => 'upload/images/company_logo/',
        'event_image' => 'upload/images/event_image/',
        'user_detail_photo' => 'upload/images/profile_image/',
        'course_category_image' => 'upload/images/course_category_image/',
        'course_sub_category_image' => 'upload/images/course_sub_category_image/',
        'book_preview_image' => 'upload/images/book_thumbnail/',
        'course_child_category_image' => 'upload/images/course_child_category_image/',
        'course_image' => 'upload/images/course_image/',
        'country_logo' => 'upload/images/country_logos/',
        'vendor_logo' => 'upload/images/vendor_logo/',
        'course_chapter_image' => 'upload/images/course_chapter_image/',
        'course_class_image' => 'upload/images/course_class_image/',
        'course_question_image' => 'upload/images/course_question_image/',
        'vendor_meeting_logo' => 'upload/images/vendor_meeting_logo/',
        'course_assignment_document' => 'upload/files/course_assignment_document/',
        'course_batch_logo' => 'upload/images/course_batch_logo/',
        'banner_image' => 'upload/images/banner_image/',
        'blog_logo' => 'upload/images/blog_logo/'
    ];

    public static $companyLogoSize = [
        'width' => 178,
        'height' => 178,
    ];

    public static $countryFlagSize = [
        'width' => 178,
        'height' => 178,
    ];

    public static $eventImageSize = [
        'width' => 1200,
        'height' => 800,
    ];

    public static $userPhotoSize = [
        'width' => 250,
        'height' => 250,
    ];

    public static $dripContentType = [
        'specific_date' => 'Specific Date',
        'days_after_enrollment' => 'Days After Enrollment',
    ];

    public static $quizType = [
        'subjective' => 'Subjective',
        'objective' => 'Objective'
    ];

    public static $bookImageSize = [
        'width' => 800,
        'height' => 800
    ];

    public static $courseImageSize = [
        'width' => 800,
        'height' => 450
    ];

    public static $vendorLogoSize = [
        'width' => 250,
        'height' => 250
    ];

    public static $courseBatchLogoSize = [
        'width' => 250,
        'height' => 250
    ];

    public static $vendorMeetingLogoSize = [
        'width' => 250,
        'height' => 250
    ];

    public static $stars = [
        '1' => 'No Star',
        '2' => '1 Star',
        '3' => '2 Stars',
        '4' => '3 Stars',
        '5' => '4 Stars',
        '6' => '5 Stars'
    ];

    public static $bannerImageSize = [
        'width' => 1980,
        'height' => 750,
    ];

    /**
     * @var int[]
     */
    public static $blogLogoSize = [
        'width' => 716,
        'height' => 320,
    ];


    /**
     * @var string[]
     */
    public static $discount_types = ['fixed' => 'Fixed Amount', 'percent' => 'Percentage'];

    /**
     * @var string[]
     */
    public static $defaultCurrency = ['ISO' => 'BDT', 'symbol' => ' ৳'];

    /**
     * @param $percentage_value
     * @param $total_value
     * @return float|int
     */
    public function percentage($percentage_value, $total_value)
    {
        return ($total_value * $percentage_value) / 100;
    }

    /**
     * Append an ordinal indicator to a numeric value.
     *
     * @param string|int $value
     * @param bool $superscript
     * @return string
     */
    public function str_ordinal($value, bool $superscript = false): string
    {
        $number = abs($value);

        $indicators = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];

        $suffix = $superscript ? '<sup>' . $indicators[$number % 10] . '</sup>' : $indicators[$number % 10];
        if ($number % 100 >= 11 && $number % 100 <= 13) {
            $suffix = $superscript ? '<sup>th</sup>' : 'th';
        }

        return number_format($number) . $suffix;
    }

    public static $FilesUploadPath = [
        'course_file' => 'upload/files/course_file/',
        'course_video' => 'upload/files/course_video/',
        'course_chapter_file' => 'upload/files/course_chapter_file/',
        'course_class_file' => 'upload/files/course_class_file/',
        'course_class_video' => 'upload/files/course_class_video/',
        'course_syllabus_file' => 'upload/files/course_syllabus_file/',
    ];

    public static $FileSize = [
        'max' => 50000,
        'min' => 1000,
    ];

    /**
     * @param array $input
     * @return array
     */
    public static function convertIndexArray(array $input): array
    {
        return [
            'on' => array_shift($input),
            'off' => array_shift($input)
        ];
    }

    /**
     * @param Carbon $start
     * @param Carbon $end
     * @return string|null
     */
    public static function getTimeRangeHuman(Carbon $start, Carbon $end): ?string
    {
        return str_replace(['after', 'ago', 'before'], ['', '', ''], $end->longRelativeDiffForHumans($start, 2));
        /*$duration = $end->diff($start)->format('%d-%h-%i');
        $durationArray = explode("-", $duration);
        $range = "";
        if ($durationArray[0] > 0)
            $range .= $durationArray[0] . ' day(s) ';
        if ($durationArray[1] > 0)
            $range .= $durationArray[1] . ' hour(s) ';
        if ($durationArray[2] > 0)
            $range .= $durationArray[2] . ' minute(s) ';

        return $range;*/
    }

    /**
     * Return Ebook Docs header Content Types
     * default 'application/octet-stream' if ext is missing
     *
     * @param string $extension
     * @return string
     */
    public static function getHeaderContentType(string $extension): string
    {
        $contentType = [
            'pdf' => 'application/pdf',
            'epub' => 'application/epub+zip',
            'azw3' => 'application/vnd.amazon.mobi8-ebook',
            'mobi' => 'application/mobi',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'txt' => 'text/plain',
            'zip' => 'application/zip',
        ];

        return (isset($contentType[$extension]))
            ? $contentType[$extension]
            : 'application/octet-stream';
    }

    /**
     * Return Unique Date time Value
     *
     * @param Carbon $extension
     * @return string
     */
    public static function getDateTimeHuman(Carbon $extension): string
    {
        $f = new UtilityService();
        $daysOfTheMonth = $f->str_ordinal($extension->format('d'), true);
        $time = $extension->format('h:ia');
        $full_month = $extension->format('F');
        $full_year = $extension->format('Y');
        $formatted_string = $time . ' (' . $daysOfTheMonth . ' ' . $full_month . ', ' . $full_year . ')';
        return $formatted_string;
    }

    /**
     * Generate URL Safe Slugs
     *
     * @param string $title
     * @return string
     */
    public static function generateSlug(string $title): string
    {
        $mainTitle = \Str::slug($title);
        $randomStr = \Str::random(10);
        return $mainTitle . '-' . $randomStr;
    }


    /**
     * @param $amount
     * @param $total
     * @param string $discount_type
     * @return float|int|string
     */
    public static function calculateDiscountAmount($amount, $total, string $discount_type = 'fixed')
    {
        if (is_numeric($amount) && $amount > 0) {
            if ($discount_type == 'percent') {
                return ($amount * $total) / 100;
            }
            return $amount;
        }
        return 0;
    }

    /**
     * @param string $string
     * @return bool
     */
    public static function validJson(string $string): bool
    {
        if (strlen($string) > 0) {
            json_decode($string);
            return (bool)json_last_error() == JSON_ERROR_NONE;
        }
        return false;
    }

    /**
     * Remove multiple index from array
     * array_diff is ok but "amar mon chai che tai"
     *
     * @param array $inputArray
     * @param array $unsetIndexArray
     * @return array
     */
    public static function subArray(array $inputArray, array $unsetIndexArray = []): array
    {
        foreach ($unsetIndexArray as $index) {
            unset($inputArray[$index]);
        }

        return $inputArray;
    }

    public static function recursiveDottedArray(string $index, &$nodeData): array
    {
        $splitedIndex = explode('.', $index, 2);

        if (count($splitedIndex) > 1) {
            return [$splitedIndex[0] => self::recursiveDottedArray($splitedIndex[1], $nodeData)];
        } else {
            return [$splitedIndex[0] => $nodeData];
        }
    }

    /**
     * @param $element
     * @return array|array[]
     */
    public static function recursivePermissionTreeArray($element): array
    {
        if (is_array($element)) {

        }
        if (count($splitedIndex) > 1) {
            return [$splitedIndex[0] => self::recursivePermissionTreeArray($splitedIndex[1])];
        } else {
            return [$splitedIndex[0] => $nodeData];
        }
    }

    /**
     * @param string $type
     * @param array $id
     * @return string|void
     */
    public static function notificationRouteByType(string $type, $id = [])
    {
        switch ($type) {
            case 'book':
                return route('books.show', $id);
                break;

            case 'course':
                return route('course.show', $id);
                break;

            case 'assignment':
                return route('course-assignments.show', $id);
                break;

            case 'event':
            case 'general':
                return route('events.show', $id);
                break;

            case 'sale':
                return route('sales.show', $id);
                break;

            case 'transaction':
                return route('transactions.show', $id);
                break;

            case 'assignment-announcement':
            case 'general-announcement':
                return route('announcements.show', $id);
                break;
        }
    }

    /**
     * @param $string
     * @param int $length
     * @param string $srcSeparator
     * @param string $targetSeparator
     * @return string
     */
    public static function daysSeparator($string, int $length = 3, string $srcSeparator = ',', string $targetSeparator = ', '): string
    {
        $array = explode($srcSeparator, $string);

        $str = '';
        if (count($array) > 1)
            foreach ($array as $day) {
                $str .= (substr($day, 0, $length) . (($day == last($array)) ? '' : $targetSeparator));
            }
        else
            $str = substr($string, 0, 3);

        return strtoupper($str);
    }
}
