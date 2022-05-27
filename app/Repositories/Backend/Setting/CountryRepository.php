<?php


namespace App\Repositories\Backend\Setting;


use App\Models\Backend\Setting\Country;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

class CountryRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return Country::class;
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
    public function CountryFilterData($filter)
    {
        $query = $this->model->sortable()->newQuery();
        if (isset($filter['search_text']) && $filter['search_text']) {
            $query->where('countries.country_iso', 'like', "%{$filter['search_text']}%");
            $query->orWhere('countries.country_name', 'like', "%{$filter['search_text']}%");
            $query->orWhere('countries.country_iso3', 'like', "%{$filter['search_text']}%");
            $query->orWhere('countries.country_num_code', 'like', "%{$filter['search_text']}%");
            $query->orWhere('countries.country_phone_code', 'like', "%{$filter['search_text']}%");
            $query->orWhere('countries.country_status', 'like', "%{$filter['search_text']}%");
        }

        if (isset($filter['id']) && $filter['id']) {
            $query->where('countries.id', '=', $filter['id']);
        }

        if (isset($filter['id_in']) && $filter['id_in']) {
            $query->whereIn('countries.id', $filter['id_in']);
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

        if (isset($filter['country_currency']) && $filter['country_currency']) {
            $query->where('countries.country_currency', '=', $filter['country_currency']);
        }

        if (isset($filter['country_status']) && $filter['country_status']) {
            $query->where('countries.country_status', '=', $filter['country_status']);
        }

        $query->select(
            [
                'countries.*', \DB::raw('CONCAT("'.url('/').'",countries.country_logo) AS country_logo')
            ]
        );

        return $query;
    }

    public function allCountryForDropdown()
    {
        return $this->model->orderBy('country_name')->get(['country_name', 'id']);
    }

}
