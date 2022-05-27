<?php


namespace App\Repositories\Backend\Setting;


use App\Models\Backend\Setting\State;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

class StateRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return State::class;
    }

    /**
     * @inheritDoc
     */
    public function filterData(array $filter, $query)
    {
        // TODO: Implement filterData() method.
    }

    /**
     * @param $filter
     * @return Builder
     */
    public function stateFilterData($filter)
    {
        $query = $this->model->sortable()->newQuery();
        $query->leftJoin('countries', 'countries.id', '=', 'states.country_id');
        if (isset($filter['search_text']) && $filter['search_text']) {
            $query->where(function($queryData) use ($filter){
                $queryData->where('countries.country_iso', 'like', "%{$filter['search_text']}%");
                $queryData->orWhere('countries.country_name', 'like', "%{$filter['search_text']}%");
                $queryData->orWhere('countries.country_iso3', 'like', "%{$filter['search_text']}%");
                $queryData->orWhere('countries.country_num_code', 'like', "%{$filter['search_text']}%");
                $queryData->orWhere('countries.country_phone_code', 'like', "%{$filter['search_text']}%");
                $queryData->orWhere('countries.country_status', 'like', "%{$filter['search_text']}%");
                $queryData->orWhere('states.state_name', 'like', "%{$filter['search_text']}%");
                $queryData->orWhere('states.state_status', 'like', "%{$filter['search_text']}%");
            });
        }

        if (isset($filter['id']) && $filter['id']) {
            $query->where('states.id', '=', $filter['id']);
        }

        if (isset($filter['country_id']) && $filter['country_id']) {
            $query->where('states.country_id', '=', $filter['country_id']);
        }

        if (isset($filter['state_name']) && $filter['state_name']) {
            $query->where(DB::raw('LOWER(states.state_name)'), '=', strtolower($filter['state_name']));
        }

        if (isset($filter['state_status']) && $filter['state_status']) {
            $query->where('states.state_status', '=', $filter['state_status']);
        }

        if (isset($filter['country_iso']) && $filter['country_iso']) {
            $query->where('countries.country_iso', '=', $filter['country_iso']);
        }

        if (isset($filter['country_name']) && $filter['country_name']) {
            $query->where('countries.country_name', '=', $filter['country_name']);
        }

        if (isset($filter['country_iso3']) && $filter['country_iso3']) {
            $query->where('countries.country_iso3', '=', $filter['country_iso3']);
        }

        if (isset($filter['country_num_code']) && $filter['country_num_code']) {
            $query->where('countries.country_num_code', '=', $filter['country_num_code']);
        }

        if (isset($filter['country_phone_code']) && $filter['country_phone_code']) {
            $query->where('countries.country_phone_code', '=', $filter['country_phone_code']);
        }

        if (isset($filter['country_status']) && $filter['country_status']) {
            $query->where('countries.country_status', '=', $filter['country_status']);
        }
        $query->select([
            'countries.country_name', \DB::raw('CONCAT("'.url('/').'",countries.country_logo) AS country_logo'), 'states.*'
        ]);
        return $query;
    }

}
