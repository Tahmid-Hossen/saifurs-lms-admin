<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SQSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('sq_setting')->insert(
            array(
                array('id' => '1','label_name' => 'SMTP Host Name','setting_name' => 'smtp_host','setting_value' => 'mail.savsoftquiz.com','order_by' => '1'),
                array('id' => '2','label_name' => 'SMTP Username','setting_name' => 'smtp_username','setting_value' => 'noreply@savsoftquiz124.com','order_by' => '2'),
                array('id' => '3','label_name' => 'SMTP Password','setting_name' => 'smtp_password','setting_value' => '123456','order_by' => '3'),
                array('id' => '4','label_name' => 'SMTP port','setting_name' => 'smtp_port','setting_value' => '587','order_by' => '4')
            )
        );
    }
}
