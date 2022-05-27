<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SQAccountTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('sq_account_type')
            ->insert(
                array(
                    array('id' => '1','account_name' => 'Admin','created_time' => '2021-01-18 19:30:08','access_permissions' => 'all'),
                    array('id' => '2','account_name' => 'User','created_time' => '2021-01-18 19:30:08','access_permissions' => 'myAccount,myQuiz,attemptQuiz,myResult,resultView')
                )
            );
    }
}
