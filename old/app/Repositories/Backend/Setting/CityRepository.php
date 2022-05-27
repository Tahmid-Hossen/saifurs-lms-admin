<?php


namespace App\Repositories\Backend\Setting;


use App\Models\Backend\Setting\City;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CityRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return City::class;
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
    public function CityFilterData($filter)
    {
        $query = $this->model->sortable()->newQuery();
        $query->leftJoin('states', 'states.id', '=', 'cities.state_id');
        $query->leftJoin('countries', 'countries.id', '=', 'states.country_id');
        if (isset($filter['search_text']) && $filter['search_text']) {
            $query->where(function($queryData) use ($filter) {
                $queryData->where('countries.country_iso', 'like', "%{$filter['search_text']}%");
                $queryData->orWhere('countries.country_name', 'like', "%{$filter['search_text']}%");
                $queryData->orWhere('countries.country_iso3', 'like', "%{$filter['search_text']}%");
                $queryData->orWhere('countries.country_num_code', 'like', "%{$filter['search_text']}%");
                $queryData->orWhere('countries.country_phone_code', 'like', "%{$filter['search_text']}%");
                $queryData->orWhere('countries.country_status', 'like', "%{$filter['search_text']}%");
                $queryData->orWhere('states.state_name', 'like', "%{$filter['search_text']}%");
                $queryData->orWhere('states.state_status', 'like', "%{$filter['search_text']}%");
                $queryData->orWhere('cities.city_name', 'like', "%{$filter['search_text']}%");
                $queryData->orWhere('cities.city_status', 'like', "%{$filter['search_text']}%");
            });
        }

        if (isset($filter['id']) && $filter['id']) {
            $query->where('states.id', '=', $filter['id']);
        }

        if (isset($filter['state_id']) && $filter['state_id']) {
            $query->where('cities.state_id', '=', $filter['state_id']);
        }

        if (isset($filter['city_name']) && $filter['city_name']) {
            $query->where(DB::raw('LOWER(cities.city_name)'), '=', strtolower($filter['city_name']));
        }

        if (isset($filter['city_status']) && $filter['city_status']) {
            $query->where('cities.city_status', '=', $filter['city_status']);
        }

        if (isset($filter['country_id']) && $filter['country_id']) {
            $query->where('states.country_id', '=', $filter['country_id']);
        }

        if (isset($filter['state_name']) && $filter['state_name']) {
            $query->where('states.state_name', '=', $filter['state_name']);
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
            'countries.country_name', \DB::raw('CONCAT("'.url('/').'",countries.country_logo) AS country_logo'),
            'states.state_name', 'cities.*'
        ]);
        return $query;
    }
}
