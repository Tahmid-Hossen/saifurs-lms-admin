<?php

namespace App\Repositories\Backend\Banner;

use App\Models\Backend\Banner\Banner;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

class BannerRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model() {
        return Banner::class;
    }

    /**
     * @param $filters
     * @return Builder
     */
    public function filterData( $filters ): Builder {
        $query = $this->model->sortable()->newQuery();

        $query->join( 'companies', 'banners.company_id', '=', 'companies.id' );

        if ( !empty( $filters ) ) {
            // Banner ID
            if ( !empty( $filters['banner_status'] ) ) {
                $query->where( 'banners.banner_status', '=', $filters['banner_status'] );
            }
            // Banner text
            if ( !empty( $filters['banner_title'] ) ) {
                $query->where( 'banners.banner_title', 'like', "%{$filters['banner_title']}%" );
            }
        }

        return $query->whereNull( 'companies.deleted_at' )
            ->select(
                [
                    'companies.*', \DB::raw( 'IFNULL(IF(companies.company_logo REGEXP "https?", companies.company_logo, CONCAT("' . url( '/' ) . '",companies.company_logo)), CONCAT("' . url( '/' ) . '","/assets/img/default.png")) AS company_logo' ),
                    'banners.*', \DB::raw( 'IFNULL(IF(banners.banner_image REGEXP "https?", banners.banner_image, CONCAT("' . url( '/' ) . '",banners.banner_image)), CONCAT("' . url( '/' ) . '","/assets/img/default.png")) AS banner_image' ),
                ]
            )->orderBy( 'banners.id', 'desc' );

    }
}
