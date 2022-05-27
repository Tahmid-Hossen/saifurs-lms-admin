<?php

namespace App\Repositories\Backend\GoogleApiKey;



use App\Models\Backend\GoogleApiKey\GoogleApiKey;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class GoogleApiKeyRepository
 * @package App\Repositories\Backend\Common
 */
class GoogleApiKeyRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return GoogleApiKey::class;
    }

    /**
     * Filter data based on user input
     *
     * @param array $filter
     * @param $query
     */
    public function filterData(array $filter, $query)
    {
        // TODO: Implement filterData() method.
    }

    /**
     * @return mixed
     */
    public function allGoogleApiKey()
    {
        return $this->model->get(['google_api_key','status', 'id', 'created_at']);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->firstOrCreate($data);
    }

    /**
     * @param $filters
     * @return Builder
     */

    public function allGoogleApiKeyList()
    {
        $query = $this->model->sortable()->newQuery();
        $query->whereNull('google_api_keys.deleted_at')->select('google_api_key','id','created_at','status')->orderBy('id','DESC');
        return $query;

    }


    public function allGoogleApiKeyFrontndList()
    {
        $query = $this->model->sortable()->newQuery();
        $query->where('status','ACTIVE')->whereNull('google_api_keys.deleted_at')->select('google_api_key','id','created_at','status')->orderBy('id','DESC');
        return $query;

    }
}

