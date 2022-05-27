<?php

namespace App\Repositories\Backend\Event;

use App\Models\Backend\Event\Event;
use App\Repositories\Repository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class EventRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return Event::class;
    }

    public function filterData($filters): Builder
    {
        $query = $this->model->sortable()->newQuery();

        $query->join('companies', 'events.company_id', '=', 'companies.id');
        // $query->join( 'branches', 'events.branch_id', '=', 'branches.id' );
        $query->orderBy('event_current_status', 'ASC');
        $query->orderBy('event_start', 'ASC');

        if (!empty($filters)) {

            //search
            if (!empty($filters['search_text'])) {
                $query->where('events.id', 'like', "%{$filters['search_text']}%");
                $query->orWhere('events.event_title', 'like', "%{$filters['search_text']}%");
                $query->orWhere('events.event_link', 'like', "%{$filters['search_text']}%");
            }

            // Search by Event Type
            if (!empty($filters['event_type'])) {
                $query->where('events.event_type', '=', $filters['event_type']);
            }

            // Search by Event's FEATURE
            if (!empty($filters['event_featured'])) {
                $query->where('events.event_featured', '=', $filters['event_featured']);
            }

            // Search by Event STATUS
            if (!empty($filters['event_status'])) {
                $query->where('events.event_status', '=', $filters['event_status']);
            }

            // Search by Event Sorting
            if (!empty($filters['event_sorting'])) {
                $query->orderBy('events.id', $filters['event_sorting']);
            }

            // Search by Event Title Sorting
            if (!empty($filters['event_sorting_by_title'])) {
                $query->orderBy('events.event_title', $filters['event_sorting_by_title']);
            }

            // Search by Event Company ID
            if (!empty($filters['company_id'])) {
                $query->where('events.company_id', '=', $filters['company_id']);
            }

            // Search Event By User Id
            if (!empty($filters['user_id']) && !empty($filters['registered_event_only'])) {
                $query->join('event_user', 'events.id', '=', 'event_user.event_id');
                $query->where('event_user.user_id', '=', $filters['user_id']);
            }

            // Search Event By User Id
            if (!empty($filters['event_current_status'])) {

                if (in_array('expired', $filters['event_current_status']) == true) {
                    $query->where('events.event_end', '<=', Carbon::now());
                } else {
                    $query->where(function ($queryString) use ($filters) {
                        $queryString->where(function ($queryStringSub) use ($filters) {
                            $queryStringSub->where('events.event_start', '<=', Carbon::now());
                            $queryStringSub->orWhere('events.event_start', '>', Carbon::now());
                        });
                        $queryString->where('events.event_end', '>=', Carbon::now());
                    });
                }
            }

        }

        return $query->whereNull('companies.deleted_at')
            ->select(
                [
                    'companies.company_name',
                    \DB::raw('IFNULL(IF(companies.company_logo REGEXP "https?", companies.company_logo, CONCAT("' . url('/') . '",companies.company_logo)), CONCAT("' . url('/') . '","/assets/img/default.png")) AS company_logo'),
                    'events.*',
                    \DB::raw('(CASE WHEN  event_start > NOW() THEN "2_Upcoming"
                    WHEN event_start <= NOW() && event_end >= NOW() THEN "1_Running"
                    ELSE "3_Expired"
                    END) AS event_current_status'),
                    \DB::raw('IFNULL(IF(`events`.`event_image` REGEXP "https?", `events`.`event_image`, CONCAT("' . url('/public/') . '",`events`.`event_image`)), CONCAT("' . url('/') . '","/assets/img/default.png")) AS event_image'),
                    \DB::raw('CONVERT_TZ(events.created_at, "+00:00", "+06:00") AS created_at'),
/*                    \DB::raw('CONVERT_TZ(events.event_start, "+00:00", "+06:00") AS event_start'),
                    \DB::raw('CONVERT_TZ(events.event_end, "+00:00", "+06:00") AS event_end')*/
                ]
            );
    }

    /**
     * @param Event $event
     * @param array $users
     * @return mixed
     */
    public function attachUsers(Event $event, array $users)
    {
        if (!empty($users)) {
            foreach ($users as $user_id => $attributes) {
                if (!$event->getEnrolledUsersList()->where('users.id', $user_id)->exists()) {
                    try {
                        $event->getEnrolledUsersList()->attach($user_id, $attributes);
                    } catch (\Exception $exception) {
                        \Log::error($exception->getMessage());
                        return ['status' => false, 'message' => 'User Already Enrolled'];
                    }
                }
            }
        }
        return ['status' => true, 'message' => 'Event Registration Successful'];
    }

    /**
     * @param Event $event
     * @param array $users
     * @return mixed
     */
    public function syncUsers(Event $event, array $users)
    {
        return $event->getEnrolledUsersList()->sync($users);
    }

}
