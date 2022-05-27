<?php

namespace App\Repositories\Backend\Notification;

use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

class NotificationRepository extends Repository {
    /**
     * @inheritDoc
     */
    public function model() {
        return NotificationRepository::class;
    }

    public function filterData( $filters ): Builder {
        $query = $this->model->sortable()->newQuery();

        $query->join( 'companies', 'events.company_id', '=', 'companies.id' );
        // $query->join( 'branches', 'events.branch_id', '=', 'branches.id' );

        if ( !empty( $filters ) ) {

            //search
            if ( !empty( $filters['search_text'] ) ) {
                $query->where( 'events.id', 'like', "%{$filters['search_text']}%" );
                $query->orWhere( 'events.event_title', 'like', "%{$filters['search_text']}%" );
                $query->orWhere( 'events.event_link', 'like', "%{$filters['search_text']}%" );
            }

            // Search by Event Type
            if ( !empty( $filters['event_type'] ) ) {
                $query->where( 'events.event_type', '=', $filters['event_type'] );
            }

            // Search by Event's FEATURE
            if ( !empty( $filters['event_featured'] ) ) {
                $query->where( 'events.event_featured', '=', $filters['event_featured'] );
            }

            // Search by Event STATUS
            if ( !empty( $filters['event_status'] ) ) {
                $query->where( 'events.event_status', '=', $filters['event_status'] );
            }

            // Search by Event Sorting
            if ( !empty( $filters['event_sorting'] ) ) {
                $query->orderBy( 'events.event_title', $filters['event_sorting'] );
            }

        }

        return $query->whereNull( 'companies.deleted_at' )
            ->select(
                [
                    'companies.company_name',
                    \DB::raw( 'IFNULL(IF(companies.company_logo REGEXP "https?", companies.company_logo, CONCAT("' . url( '/' ) . '",companies.company_logo)), CONCAT("' . url( '/' ) . '","/assets/img/default.png")) AS company_logo' ),
                    'events.*',
                    \DB::raw( 'IFNULL(IF(events.event_image REGEXP "https?", events.event_image, CONCAT("' . url( '/' ) . '",events.event_image)), CONCAT("' . url( '/' ) . '","/assets/img/default.png")) AS event_image' ),
                ]
            )->orderBy( 'events.id', 'desc' );
    }

}
