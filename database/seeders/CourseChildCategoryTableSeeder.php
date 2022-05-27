<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\Course\CourseChildCategory;
use App\Models\Backend\Course\CourseSubCategory;
use App\Models\Backend\User\Company;
use App\Models\Backend\Course\CourseCategory;
use App\Support\Configs\Constants;

class CourseChildCategoryTableSeeder extends Seeder
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

        $courseSubCatSSC = CourseSubCategory::where('course_sub_category_title', '=', 'SSC')->first();
        $courseSubCatHSC = CourseSubCategory::where('course_sub_category_title', '=', 'HSC')->first();
        $courseSubCatBank = CourseSubCategory::where('course_sub_category_title', '=', 'Bank')->first();
        $courseSubCatNGO = CourseSubCategory::where('course_sub_category_title', '=', 'NGO')->first();
        $courseSubCatNTRCA = CourseSubCategory::where('course_sub_category_title', '=', 'NTRCA')->first();
        $courseSubCatResearch = CourseSubCategory::where('course_sub_category_title', '=', 'Research')->first();
        $courseSubCatMinistry = CourseSubCategory::where('course_sub_category_title', '=', 'Ministry')->first();
        $courseSubCatIELTS = CourseSubCategory::where('course_sub_category_title', '=', 'IELTS')->first();
        $courseSubCatTOEFL = CourseSubCategory::where('course_sub_category_title', '=', 'TOEFL')->first();
        $courseSubCatGRE = CourseSubCategory::where('course_sub_category_title', '=', 'GRE')->first();
        $courseSubCatGMAT = CourseSubCategory::where('course_sub_category_title', '=', 'GMAT')->first();

        /****************************************aleshaCompany***************************************************/
        // Academic-SSC
        CourseChildCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_id' => $courseSubCatSSC->id,
            'course_child_category_title' => 'Science',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_id' => $courseSubCatSSC->id,
            'course_child_category_title' => 'Arts',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_id' => $courseSubCatSSC->id,
            'course_child_category_title' => 'Commerce',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        // Academic-HSC
        CourseChildCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_id' => $courseSubCatHSC->id,
            'course_child_category_title' => 'Science',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_id' => $courseSubCatHSC->id,
            'course_child_category_title' => 'Arts',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_id' => $courseSubCatHSC->id,
            'course_child_category_title' => 'Commerce',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        // Government-Bank
        CourseChildCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatBank->id,
            'course_child_category_title' => 'Bangla',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatBank->id,
            'course_child_category_title' => 'English',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatBank->id,
            'course_child_category_title' => 'Math',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatBank->id,
            'course_child_category_title' => 'General Knowledge',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        // English-IELTS
        CourseChildCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatIELTS->id,
            'course_child_category_title' => 'Reading',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatIELTS->id,
            'course_child_category_title' => 'Writing',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatIELTS->id,
            'course_child_category_title' => 'Listening',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $aleshaCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatIELTS->id,
            'course_child_category_title' => 'Speaking',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        /****************************************saifursGroupCompany***************************************************/
        // Academic-SSC
        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_id' => $courseSubCatSSC->id,
            'course_child_category_title' => 'Science',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_id' => $courseSubCatSSC->id,
            'course_child_category_title' => 'Arts',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_id' => $courseSubCatSSC->id,
            'course_child_category_title' => 'Commerce',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        // Academic-HSC
        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_id' => $courseSubCatHSC->id,
            'course_child_category_title' => 'Science',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatAcademic->id,
            'course_sub_category_id' => $courseSubCatHSC->id,
            'course_child_category_title' => 'Commerce',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        // Government-Bank
        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatBank->id,
            'course_child_category_title' => 'Bangla',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatBank->id,
            'course_child_category_title' => 'English',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatBank->id,
            'course_child_category_title' => 'Math',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatBank->id,
            'course_child_category_title' => 'General Knowledge',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatBank->id,
            'course_child_category_title' => 'Computer Skill',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        // Government-NTRCA
        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatNTRCA->id,
            'course_child_category_title' => 'Bangla',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatNTRCA->id,
            'course_child_category_title' => 'General Math',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatNTRCA->id,
            'course_child_category_title' => 'World Information',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        // English
        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatIELTS->id,
            'course_child_category_title' => 'Reading',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatIELTS->id,
            'course_child_category_title' => 'Writing',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatIELTS->id,
            'course_child_category_title' => 'Listening',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatIELTS->id,
            'course_child_category_title' => 'Speaking',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatTOEFL->id,
            'course_child_category_title' => 'Reading',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatTOEFL->id,
            'course_child_category_title' => 'Writing',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatGRE->id,
            'course_child_category_title' => 'Mathematics',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatGRE->id,
            'course_child_category_title' => 'Physics',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatGMAT->id,
            'course_child_category_title' => 'Analytical Writing',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatGMAT->id,
            'course_child_category_title' => 'Integrated Reasoning',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $saifursGroupCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatGMAT->id,
            'course_child_category_title' => 'Quantitative Aptitude Section',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        /****************************************udvashCompany***************************************************/
        // Government-NGO
        CourseChildCategory::create([
            'company_id' => $udvashCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatNGO->id,
            'course_child_category_title' => 'Computer Skill',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $udvashCompany->id,
            'course_category_id' => $courseCatGovernment->id,
            'course_sub_category_id' => $courseSubCatNGO->id,
            'course_child_category_title' => 'Global Information',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        // English-TOEFL
        CourseChildCategory::create([
            'company_id' => $udvashCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatTOEFL->id,
            'course_child_category_title' => 'Listening',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $udvashCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatTOEFL->id,
            'course_child_category_title' => 'Speaking',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        // English-GRE
        CourseChildCategory::create([
            'company_id' => $udvashCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatGRE->id,
            'course_child_category_title' => 'Chemistry',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);

        CourseChildCategory::create([
            'company_id' => $udvashCompany->id,
            'course_category_id' => $courseCatEnglish->id,
            'course_sub_category_id' => $courseSubCatGRE->id,
            'course_child_category_title' => 'Psychology',
            'course_child_category_details' => 'This Course Category is an online based which includes course material accessibility, flexible scheduling, more academic options, and the opportunity to build valuable skills. In addition, with online learning, a student may develop the technological skills needed in their future careers.',
            'course_child_category_featured' => Constants::$course_featured[0],
            'course_child_category_status' => Constants::$course_status[1]
        ]);


    }
}
