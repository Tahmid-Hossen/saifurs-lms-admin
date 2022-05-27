<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\Course\CourseSubCategory;
use App\Models\Backend\User\Company;
use App\Models\Backend\Course\CourseCategory;
use App\Support\Configs\Constants;

class CourseSubCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aleshaCompany = Company::where('company_email', '=', 'info@aleshatech.com')->first();
        $udvashCompany = Company::where('company_email', '=', 'info@udvash.com')->first();
        $saifursGroupCompany= Company::where('company_email', '=', 'info@saifursgroup.com')->first();
        $retinaBDCompany = Company::where('company_email', '=', 'info@retinabd.com')->first();

        $courseCatAcademic = CourseCategory::where('course_category_title', '=', 'Academic')->first();
        $courseCatGovernment = CourseCategory::where('course_category_title', '=', 'Government')->first();
        $courseCatEnglish = CourseCategory::where('course_category_title', '=', 'English')->first();

        /****************************************Academic***************************************************/
        // Company aleshaCompany
        CourseSubCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'SSC',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        CourseSubCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'HSC',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        // Company udvashCompany
        CourseSubCategory::create([
            'company_id' => $udvashCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'SSC',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        CourseSubCategory::create([
            'company_id' => $udvashCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'HSC',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        // Company saifursGroupCompany
        CourseSubCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'SSC',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        CourseSubCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'HSC',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        // Company retinaBDCompany
        CourseSubCategory::create([
            'company_id' => $retinaBDCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'SSC',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        CourseSubCategory::create([
            'company_id' => $retinaBDCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'HSC',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        /****************************************Government***************************************************/
        // Company aleshaCompany
        CourseSubCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_title' => 'Bank',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        CourseSubCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_title' => 'NGO',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        CourseSubCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_title' => 'NTRCA',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        CourseSubCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_title' => 'Project',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        // Company udvashCompany
        CourseSubCategory::create([
            'company_id' => $udvashCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_title' => 'Bank',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        CourseSubCategory::create([
            'company_id' => $udvashCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_title' => 'NGO',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        // Company saifursGroupCompany
        CourseSubCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_title' => 'Bank',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        CourseSubCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_title' => 'NTRCA',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        CourseSubCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_title' => 'Research',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        // Company retinaBDCompany
        CourseSubCategory::create([
            'company_id' => $retinaBDCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_title' => 'NGO',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        CourseSubCategory::create([
            'company_id' => $retinaBDCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_title' => 'Ministry',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        /****************************************English***************************************************/
        // Company aleshaCompany
        CourseSubCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'IELTS',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        CourseSubCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'TOEFL',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        // Company udvashCompany
        CourseSubCategory::create([
            'company_id' => $udvashCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'GRE',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        CourseSubCategory::create([
            'company_id' => $udvashCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'GMAT',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        // Company saifursGroupCompany
        CourseSubCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'IELTS',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        CourseSubCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'TOEFL',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        CourseSubCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'GRE',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        CourseSubCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'GMAT',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        // Company retinaBDCompany
        CourseSubCategory::create([
            'company_id' => $retinaBDCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'TOEFL',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);

        CourseSubCategory::create([
            'company_id' => $retinaBDCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_title' => 'GRE',
            'course_sub_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_sub_category_featured' => Constants::$course_featured[0],
            'course_sub_category_status' => Constants::$course_status[1]
        ]);


    }
}
