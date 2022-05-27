<?php

namespace Database\Seeders;

use App\Models\Backend\BranchLocation\Branch_location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();


       /* $this->call(UsersTableSeeder::class);*/

      /*  $this->call(FaqSeeder::class);*/
        $this->call(BookPriceListSeeder::class);
       /* $this->call(Branch_location::class);*/
        $this->call(UsersTableSeeder::class);

        $this->call(CountryTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(BranchTableSeeder::class);
        $this->call(UserDetailTableSeeder::class);

        $this->call(RolesTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);



      //Book
        $this->call(BookTableSeeder::class);

        //Sale
        //$this->call(SaleTableSeeder::class);

        $this->call(CourseCategoryTableSeeder::class);

        //$this->call(CourseTableSeeder::class);

        // Banner
        $this->call(BannersTableSeeder::class);

        // Event
        $this->call(EventsTableSeeder::class);

        // Quiz
        // $this->call(QuizzesTableSeeder::class);
        $this->call(SQSettingTableSeeder::class);

        // Announcement
        //$this->call(AnnouncementsTableSeeder::class);

        //$this->call(TagTableSeeder::class);

        $this->call(VendorTableSeeder::class);

        $this->call(TeacherUsersTableSeeder::class);
        $this->call(TeacherTableSeeder::class);
        $this->call(RoleTeacherTableSeeder::class);

        $this->call(StudentUsersTableSeeder::class);
        $this->call(StudentTableSeeder::class);
        $this->call(RoleStudentTableSeeder::class);

        // Course Manage Section
        //         $this->call(CourseChapterTableSeeder::class);
        //         $this->call(CourseClassTableSeeder::class);
        //$this->call(CourseRatingsTableSeeder::class);

        // Coupon Manage Section
        $this->call(CouponsTableSeeder::class);

        //Event User Join List
        $this->call(EventRegisterSeeder::class);

        //Keep it on Lst Always
        $this->call(PermissionSeeder::class);
        $this->call(AssignRolePermissionSeeder::class);
        $this->call(PermissionTableSeeder::class);
    }
}
