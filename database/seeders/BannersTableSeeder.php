<?php

namespace Database\Seeders;

use App\Models\Backend\Banner\Banner;
use App\Models\Backend\User\Company;
use App\Support\Configs\Constants;
use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $timestamp = date( 'Y-m-d H:i:s' );
        $status = Constants::$user_active_status;
        $saifursGroupCompany = Company::where( 'company_email', '=', 'info@saifursgroup.com' )->first();
        $aleshaTechCompany = Company::where( 'company_email', '=', 'info@aleshatech.com' )->first();
        $banners = [
            [
                'company_id'    => $aleshaTechCompany->id,
                'banner_title'  => 'Interactive Learning',
                'banner_image'  => '/assets/img/static/banner1.png',
                'banner_status' => $status,
                'created_at'    => $timestamp,
                'updated_at'    => $timestamp,
            ],
            [
                'company_id'    => $saifursGroupCompany->id,
                'banner_title'  => 'Study For Fun',
                'banner_image'  => '/assets/img/static/banner2.png',
                'banner_status' => $status,
                'created_at'    => $timestamp,
                'updated_at'    => $timestamp,
            ],
            [
                'company_id'    => $aleshaTechCompany->id,
                'banner_title'  => 'Study For Fun',
                'banner_image'  => '/assets/img/static/banner2.png',
                'banner_status' => $status,
                'created_at'    => $timestamp,
                'updated_at'    => $timestamp,
            ],
            [
                'company_id'    => $saifursGroupCompany->id,
                'banner_title'  => 'Interactive Learning',
                'banner_image'  => '/assets/img/static/banner1.png',
                'banner_status' => $status,
                'created_at'    => $timestamp,
                'updated_at'    => $timestamp,
            ],
        ];
        foreach ( $banners as $banner ) {
            try {
                Banner::create( $banner );
            } catch ( \PDOException $exception ) {
                throw new \PDOException( $exception->getMessage() );
            }
        }
    }
}
