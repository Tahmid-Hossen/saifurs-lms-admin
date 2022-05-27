<?php

namespace Database\Seeders;

use App\Models\Backend\Common\Tag;
use Illuminate\Database\Seeder;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseChildCategory;
use App\Models\Backend\Course\CourseSubCategory;
use App\Models\Backend\User\Company;
use App\Models\Backend\Course\CourseCategory;
use App\Support\Configs\Constants;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $udvashCompany = Company::where('company_email', '=', 'info@udvash.com')->first();
        $saifursGroupCompany= Company::where('company_email', '=', 'info@saifursgroup.com')->first();
        $retinaBDCompany = Company::where('company_email', '=', 'info@retinabd.com')->first();
        $aleshaTechCompany = Company::where('company_email', '=', 'info@aleshatech.com')->first();

        $courseCatAcademic = CourseCategory::where('course_category_title', '=', 'Academic')->first();
        $courseCatGovernment = CourseCategory::where('course_category_title', '=', 'Government')->first();
        $courseCatEnglish = CourseCategory::where('course_category_title', '=', 'English')->first();

        $courseSubCatSSC = CourseSubCategory::where('course_sub_category_title', '=', 'SSC')->first();
        $courseSubCatHSC = CourseSubCategory::where('course_sub_category_title', '=', 'HSC')->first();
        $courseSubCatBank = CourseSubCategory::where('course_sub_category_title', '=', 'Bank')->first();
        $courseSubCatNTRCA = CourseSubCategory::where('course_sub_category_title', '=', 'NTRCA')->first();
        $courseSubCatIELTS = CourseSubCategory::where('course_sub_category_title', '=', 'IELTS')->first();

        $courseChildCatScience = CourseChildCategory::where('course_child_category_title', '=', 'Science')->first();
        $courseChildCatCommerce = CourseChildCategory::where('course_child_category_title', '=', 'Commerce')->first();
        $courseChildCatBangla = CourseChildCategory::where('course_child_category_title', '=', 'Bangla')->first();
        $courseChildCatMath = CourseChildCategory::where('course_child_category_title', '=', 'Math')->first();
        $courseChildCatReading = CourseChildCategory::where('course_child_category_title', '=', 'Reading')->first();
        $courseChildCatWriting = CourseChildCategory::where('course_child_category_title', '=', 'Writing')->first();
        $courseChildCatGK = CourseChildCategory::where('course_child_category_title', '=', 'General Knowledge')->first();
        $courseChildCatSpeaking = CourseChildCategory::where('course_child_category_title', '=', 'Speaking')->first();

        /**************************************aleshaTechCompany*************************************/
        // Academic
        Course::create(array(
            'company_id' => $aleshaTechCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_id' => $courseSubCatSSC->id,
            'course_child_category_id' => $courseChildCatScience->id,
            'course_title' => 'Subjective',
            'course_short_description' => 'Computer component files !!.',
            'course_image' => '/assets/img/static/course.jpg',
            'course_duration' => 'Days',
            'course_duration_expire' => 10,
            'course_is_assignment' => Constants::$course_default_assignment,
            'course_is_certified' => Constants::$course_default_certified,
            'course_is_subscribed' => Constants::$course_default_subscribed,
            'course_featured' => Constants::$course_default_featured,
            'course_status' => Constants::$course_active_status,
            'course_language' => Constants::$course_default_language,
            'course_discount' => 40.0,

            'course_download_able' => Constants::$course_default_download,
        ));

        Course::create(array(
            'company_id' => $aleshaTechCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_id' => $courseSubCatSSC->id,
            'course_child_category_id' => $courseChildCatCommerce->id,
            'course_title' => 'Objective',
            'course_short_description' => 'Computer component files !!.',
            'course_image' => '/assets/img/static/course.jpg',
            'course_duration' => 'Days',
            'course_duration_expire' => 10,
            'course_is_assignment' => Constants::$course_default_assignment,
            'course_is_certified' => Constants::$course_default_certified,
            'course_is_subscribed' => Constants::$course_default_subscribed,
            'course_featured' => Constants::$course_default_featured,
            'course_status' => Constants::$course_active_status,
            'course_language' => Constants::$course_default_language,
            'course_discount' => 40.0,

            'course_download_able' => Constants::$course_default_download,
        ));

        // Govt
        Course::create(array(
            'company_id' => $aleshaTechCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatBank->id,
            'course_child_category_id' => $courseChildCatBangla->id,
            'course_title' => 'Written',
            'course_short_description' => 'Computer component files !!.',
            'course_image' => '/assets/img/static/course.jpg',
            'course_duration' => 'Days',
            'course_duration_expire' => 10,
            'course_is_assignment' => Constants::$course_default_assignment,
            'course_is_certified' => Constants::$course_default_certified,
            'course_is_subscribed' => Constants::$course_default_subscribed,
            'course_featured' => Constants::$course_default_featured,
            'course_status' => Constants::$course_active_status,
            'course_language' => Constants::$course_default_language,
            'course_discount' => 40.0,

            'course_download_able' => Constants::$course_default_download,
        ));

        Course::create(array(
            'company_id' => $aleshaTechCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatBank->id,
            'course_child_category_id' => $courseChildCatMath->id,
            'course_title' => 'Viva',
            'course_short_description' => 'Computer component files !!.',
            'course_image' => '/assets/img/static/course.jpg',
            'course_duration' => 'Days',
            'course_duration_expire' => 10,
            'course_is_assignment' => Constants::$course_default_assignment,
            'course_is_certified' => Constants::$course_default_certified,
            'course_is_subscribed' => Constants::$course_default_subscribed,
            'course_featured' => Constants::$course_default_featured,
            'course_status' => Constants::$course_active_status,
            'course_language' => Constants::$course_default_language,
            'course_discount' => 40.0,

            'course_download_able' => Constants::$course_default_download,
        ));

        // English
        Course::create(array(
            'company_id' => $aleshaTechCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatIELTS->id,
            'course_child_category_id' => $courseChildCatReading->id,
            'course_title' => 'Basic Reading',
            'course_short_description' => 'Computer component files !!.',
            'course_image' => '/assets/img/static/course.jpg',
            'course_duration' => 'Days',
            'course_duration_expire' => 10,
            'course_is_assignment' => Constants::$course_default_assignment,
            'course_is_certified' => Constants::$course_default_certified,
            'course_is_subscribed' => Constants::$course_default_subscribed,
            'course_featured' => Constants::$course_default_featured,
            'course_status' => Constants::$course_active_status,
            'course_language' => Constants::$course_default_language,
            'course_discount' => 40.0,

            'course_download_able' => Constants::$course_default_download,
        ));

        Course::create(array(
            'company_id' => $aleshaTechCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatIELTS->id,
            'course_child_category_id' => $courseChildCatReading->id,
            'course_title' => 'Advanced Reading',
            'course_short_description' => 'Computer component files !!.',
            'course_image' => '/assets/img/static/course.jpg',
            'course_duration' => 'Days',
            'course_duration_expire' => 10,
            'course_is_assignment' => Constants::$course_default_assignment,
            'course_is_certified' => Constants::$course_default_certified,
            'course_is_subscribed' => Constants::$course_default_subscribed,
            'course_featured' => Constants::$course_default_featured,
            'course_status' => Constants::$course_active_status,
            'course_language' => Constants::$course_default_language,
            'course_discount' => 40.0,

            'course_download_able' => Constants::$course_default_download,
        ));

        /**************************************saifursGroupCompany*************************************/
        // Academic
        Course::create(array(
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_id' => $courseSubCatHSC->id,
            'course_child_category_id' => $courseChildCatScience->id,
            'course_title' => 'Subjective',
            'course_short_description' => 'Computer component files !!.',
            'course_image' => '/assets/img/static/course.jpg',
            'course_duration' => 'Days',
            'course_duration_expire' => 10,
            'course_is_assignment' => Constants::$course_default_assignment,
            'course_is_certified' => Constants::$course_default_certified,
            'course_is_subscribed' => Constants::$course_default_subscribed,
            'course_featured' => Constants::$course_default_featured,
            'course_status' => Constants::$course_active_status,
            'course_language' => Constants::$course_default_language,
            'course_discount' => 40.0,

            'course_download_able' => Constants::$course_default_download,
        ));

        Course::create(array(
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_id' => $courseSubCatHSC->id,
            'course_child_category_id' => $courseChildCatCommerce->id,
            'course_title' => 'Objective',
            'course_short_description' => 'Computer component files !!.',
            'course_image' => '/assets/img/static/course.jpg',
            'course_duration' => 'Days',
            'course_duration_expire' => 10,
            'course_is_assignment' => Constants::$course_default_assignment,
            'course_is_certified' => Constants::$course_default_certified,
            'course_is_subscribed' => Constants::$course_default_subscribed,
            'course_featured' => Constants::$course_default_featured,
            'course_status' => Constants::$course_active_status,
            'course_language' => Constants::$course_default_language,
            'course_discount' => 40.0,

            'course_download_able' => Constants::$course_default_download,
        ));

        // Govt
        Course::create(array(
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatBank->id,
            'course_child_category_id' => $courseChildCatMath->id,
            'course_title' => 'Written',
            'course_short_description' => 'Computer component files !!.',
            'course_image' => '/assets/img/static/course.jpg',
            'course_duration' => 'Days',
            'course_duration_expire' => 10,
            'course_is_assignment' => Constants::$course_default_assignment,
            'course_is_certified' => Constants::$course_default_certified,
            'course_is_subscribed' => Constants::$course_default_subscribed,
            'course_featured' => Constants::$course_default_featured,
            'course_status' => Constants::$course_active_status,
            'course_language' => Constants::$course_default_language,
            'course_discount' => 40.0,

            'course_download_able' => Constants::$course_default_download,
        ));

        Course::create(array(
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatBank->id,
            'course_child_category_id' => $courseChildCatMath->id,
            'course_title' => 'Viva',
            'course_short_description' => 'Computer component files !!.',
            'course_image' => '/assets/img/static/course.jpg',
            'course_duration' => 'Days',
            'course_duration_expire' => 10,
            'course_is_assignment' => Constants::$course_default_assignment,
            'course_is_certified' => Constants::$course_default_certified,
            'course_is_subscribed' => Constants::$course_default_subscribed,
            'course_featured' => Constants::$course_default_featured,
            'course_status' => Constants::$course_active_status,
            'course_language' => Constants::$course_default_language,
            'course_discount' => 40.0,

            'course_download_able' => Constants::$course_default_download,
        ));

        Course::create(array(
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatBank->id,
            'course_child_category_id' => $courseChildCatGK->id,
            'course_title' => 'Written',
            'course_short_description' => 'Computer component files !!.',
            'course_image' => '/assets/img/static/course.jpg',
            'course_duration' => 'Days',
            'course_duration_expire' => 10,
            'course_is_assignment' => Constants::$course_default_assignment,
            'course_is_certified' => Constants::$course_default_certified,
            'course_is_subscribed' => Constants::$course_default_subscribed,
            'course_featured' => Constants::$course_default_featured,
            'course_status' => Constants::$course_active_status,
            'course_language' => Constants::$course_default_language,
            'course_discount' => 40.0,

            'course_download_able' => Constants::$course_default_download,
        ));

        Course::create(array(
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatBank->id,
            'course_child_category_id' => $courseChildCatGK->id,
            'course_title' => 'Viva',
            'course_short_description' => 'Computer component files !!.',
            'course_image' => '/assets/img/static/course.jpg',
            'course_duration' => 'Days',
            'course_duration_expire' => 10,
            'course_is_assignment' => Constants::$course_default_assignment,
            'course_is_certified' => Constants::$course_default_certified,
            'course_is_subscribed' => Constants::$course_default_subscribed,
            'course_featured' => Constants::$course_default_featured,
            'course_status' => Constants::$course_active_status,
            'course_language' => Constants::$course_default_language,
            'course_discount' => 40.0,

            'course_download_able' => Constants::$course_default_download,
        ));

        // English
        Course::create(array(
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatIELTS->id,
            'course_child_category_id' => $courseChildCatSpeaking->id,
            'course_title' => 'Basic Speaking',
            'course_short_description' => 'Computer component files !!.',
            'course_image' => '/assets/img/static/course.jpg',
            'course_duration' => 'Days',
            'course_duration_expire' => 10,
            'course_is_assignment' => Constants::$course_default_assignment,
            'course_is_certified' => Constants::$course_default_certified,
            'course_is_subscribed' => Constants::$course_default_subscribed,
            'course_featured' => Constants::$course_default_featured,
            'course_status' => Constants::$course_active_status,
            'course_language' => Constants::$course_default_language,
            'course_discount' => 40.0,

            'course_download_able' => Constants::$course_default_download,
        ));

        Course::create(array(
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatIELTS->id,
            'course_child_category_id' => $courseChildCatSpeaking->id,
            'course_title' => 'Advanced Speaking',
            'course_short_description' => 'Computer component files !!.',
            'course_image' => '/assets/img/static/course.jpg',
            'course_duration' => 'Days',
            'course_duration_expire' => 10,
            'course_is_assignment' => Constants::$course_default_assignment,
            'course_is_certified' => Constants::$course_default_certified,
            'course_is_subscribed' => Constants::$course_default_subscribed,
            'course_featured' => Constants::$course_default_featured,
            'course_status' => Constants::$course_active_status,
            'course_language' => Constants::$course_default_language,
            'course_discount' => 40.0,

            'course_download_able' => Constants::$course_default_download,
        ));


    }
}
