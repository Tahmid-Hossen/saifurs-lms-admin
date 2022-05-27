<?php


namespace App\Repositories\Backend\User;


use App\Models\Backend\User\Company;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

class CompanyRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return Company::class;
    }

    /**
     * @param array $filter
     * @param $query
     */
    public function filterData(array $filter, $query)
    {
        // TODO: Implement filterData() method.
    }

    /**
     * @param $filters
     * @return Builder
     */
    public function companyFilterData($filters): Builder
    {
        $query = $this->model->sortable()->newQuery();

        $query->leftJoin('countries', 'countries.id', '=', 'companies.country_id');
        $query->leftJoin('states', 'states.id', '=', 'companies.state_id');
        $query->leftJoin('cities', 'cities.id', '=', 'companies.city_id');

        if (isset($filters['search_text']) && $filters['search_text']) {
            $query->where('companies.company_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_email', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_phone', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_mobile', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_address', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_zip_code', 'like', "%{$filters['search_text']}%");
            $query->orWhere('states.state_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('cities.city_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('countries.country_name', 'like', "%{$filters['search_text']}%");
        }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('companies.id', '=', $filters['id']);
        }
        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('companies.id', '=', $filters['company_id']);
        }
        if (isset($filters['company_id_not']) && $filters['company_id_not']) {
            $query->where('companies.id', '!=', $filters['company_id_not']);
        }
        if (isset($filters['company_name']) && $filters['company_name']) {
            $query->where('companies.company_name', '=', $filters['company_name']);
        }
        if (isset($filters['company_email']) && $filters['company_email']) {
            $query->where('companies.company_email', '=', $filters['company_email']);
        }
        if (isset($filters['company_phone']) && $filters['company_phone']) {
            $query->where('companies.company_phone', '=', $filters['company_phone']);
        }
        if (isset($filters['company_mobile']) && $filters['company_mobile']) {
            $query->where('companies.company_mobile', '=', $filters['company_mobile']);
        }
        if (isset($filters['company_address']) && $filters['company_address']) {
            $query->where('companies.company_address', 'like', "%{$filters['company_address']}%");
        }
        if (isset($filters['company_zip_code']) && $filters['company_zip_code']) {
            $query->where('companies.company_zip_code', '=', $filters['company_zip_code']);
        }
        if (isset($filters['state_id']) && $filters['state_id']) {
            $query->where('companies.state_id', '=', $filters['state_id']);
        }
        if (isset($filters['state_name']) && $filters['state_name']) {
            $query->where('states.state_name', '=', $filters['state_name']);
        }
        if (isset($filters['city_id']) && $filters['city_id']) {
            $query->where('companies.city_id', '=', $filters['city_id']);
        }
        if (isset($filters['city_name']) && $filters['city_name']) {
            $query->where('cities.city_name', '=', $filters['city_name']);
        }
        if (isset($filters['country_id']) && $filters['country_id']) {
            $query->where('companies.country_id', '=', $filters['country_id']);
        }
        if (isset($filters['country_name']) && $filters['country_name']) {
            $query->where('countries.country_name', '=', $filters['country_name']);
        }

        if (isset($filters['company_status']) && $filters['company_status']) {
            $query->where('companies.company_status', '=', $filters['company_status']);
        }

        $query->select([
            'cities.city_name', 'states.state_name', 'countries.country_name', 'companies.*', 'companies.company_logo AS company_logo_link',
            \DB::raw('IFNULL(IF(companies.company_logo REGEXP "http", companies.company_logo, CONCAT("'.url('/').'",companies.company_logo)), CONCAT("'.url('/').'","/assets/img/default.png")) AS company_logo'),
        ]);
        return $query;
    }

}
