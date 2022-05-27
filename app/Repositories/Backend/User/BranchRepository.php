<?php


namespace App\Repositories\Backend\User;


use App\Models\Backend\User\Branch;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

class BranchRepository extends Repository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Branch::class;
    }

    /**
     * @inheritDoc
     */
    public function filterData(array $filter, $query)
    {
        // TODO: Implement filterData() method.
    }

    public function branchFilterData($filters): Builder
    {
        $query = $this->model->sortable()->newQuery();

        $query->leftJoin('companies', 'companies.id', '=', 'branches.company_id');
        $query->leftJoin('countries', 'countries.id', '=', 'branches.country_id');
        $query->leftJoin('states', 'states.id', '=', 'branches.state_id');
        $query->leftJoin('cities', 'cities.id', '=', 'branches.city_id');

        if (isset($filters['search_text']) && $filters['search_text']) {
            $query->where('branches.branch_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('branches.manager_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('branches.branch_phone', 'like', "%{$filters['search_text']}%");
            $query->orWhere('branches.branch_mobile', 'like', "%{$filters['search_text']}%");
            $query->orWhere('branches.branch_email', 'like', "%{$filters['search_text']}%");
            $query->orWhere('branches.branch_address', 'like', "%{$filters['search_text']}%");
            $query->orWhere('branches.address_bn', 'like', "%{$filters['search_text']}%");
            $query->orWhere('branches.branch_zip_code', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_email', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_phone', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_mobile', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_address', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_zip_code', 'like', "%{$filters['search_text']}%");
            $query->orWhere('states.state_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('cities.city_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('countries.country_name', 'like', "%{$filters['search_text']}%");
        }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('branches.id', '=', $filters['id']);
        }
        if (isset($filters['branch_id']) && $filters['branch_id']) {
            $query->where('branches.id', '=', $filters['branch_id']);
        }
        if (isset($filters['branch_phone']) && $filters['branch_phone']) {
            $query->where('branches.branch_phone', '=', $filters['branch_phone']);
        }
        if (isset($filters['branch_mobile']) && $filters['branch_mobile']) {
            $query->where('branches.branch_mobile', '=', $filters['branch_mobile']);
        }
        if (isset($filters['branch_email']) && $filters['email']) {
            $query->where('branches.branch_email', '=', $filters['branch_email']);
        }
        if (isset($filters['branch_zip_code']) && $filters['branch_zip_code']) {
            $query->where('branches.branch_zip_code', '=', $filters['branch_zip_code']);
        }
        if (isset($filters['branch_status']) && $filters['branch_status']) {
            $query->where('branches.branch_status', '=', $filters['branch_status']);
        }

        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('branches.company_id', '=', $filters['company_id']);
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
        if (isset($filters['id']) && $filters['id']) {
            $query->where('companies.company_address', 'like', "%{$filters['company_address']}%");
        }
        if (isset($filters['company_zip_code']) && $filters['company_zip_code']) {
            $query->where('companies.company_zip_code', '=', $filters['company_zip_code']);
        }
        if (isset($filters['state_id']) && $filters['state_id']) {
            $query->where('branches.state_id', '=', $filters['state_id']);
        }
        if (isset($filters['state_name']) && $filters['state_name']) {
            $query->where('states.state_name', '=', $filters['state_name']);
        }
        if (isset($filters['city_id']) && $filters['city_id']) {
            $query->where('branches.city_id', '=', $filters['city_id']);
        }
        if (isset($filters['city_name']) && $filters['city_name']) {
            $query->where('cities.city_name', '=', $filters['city_name']);
        }
        if (isset($filters['country_id']) && $filters['country_id']) {
            $query->where('branches.country_id', '=', $filters['country_id']);
        }
        if (isset($filters['country_name']) && $filters['country_name']) {
            $query->where('countries.country_name', '=', $filters['country_name']);
        }
        if (isset($filters['branch_status']) && $filters['branch_status']) {
            $query->where('branches.branch_status', '=', $filters['branch_status']);
        }

        $query->select([
            'cities.city_name', 'states.state_name', 'countries.country_name',
            'companies.*', \DB::raw('CONCAT("'.url('/').'",companies.company_logo) AS company_logo'),
            'branches.*'
        ]);
        return $query;
    }
}
