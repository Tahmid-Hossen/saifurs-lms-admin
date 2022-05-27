<?php

namespace App\Services\Backend\GoogleApiKey;

use App\Repositories\Backend\GoogleApiKey\GoogleApiKeyRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Class KeywordService
 * @package App\Services\Backend\Common
 */
class GoogleApiKeyService
{
    /**
     * @var GoogleApiKeyRepository
     */
    private $GoogleApiKeyRepository;

    /**
     * FaqService constructor.
     * @param GoogleApiKeyRepository $GoogleApiKeyRepository
     */
    public function __construct(GoogleApiKeyRepository $GoogleApiKeyRepository)
    {

        $this->GoogleApiKeyRepository = $GoogleApiKeyRepository;
    }

    /**
     * @param array $input
     *
     * @return mixed
     */
    public function storeGoogleApiKey(array $input)
    {
        try {
            return $this->GoogleApiKeyRepository->create($input);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function updateGoogleApiKey($input, $id)
    {
        try {
            $GoogleApiKey = $this->GoogleApiKeyRepository->find($id);
            $this->GoogleApiKeyRepository->update($input, $id);
            return $GoogleApiKey;
        } catch (ModelNotFoundException $e) {
            Log::error('GoogleApiKey not found');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function showGoogleApiKeyByID($id)
    {
        return $this->GoogleApiKeyRepository->find($id);
    }

    /**
     * @param $input
     * @return mixed
     */
    public function ShowAllGoogleApiKey()
    {
        return $this->GoogleApiKeyRepository->allGoogleApiKeyList();
    }

    public function ShowAllGoogleApiKeyFrontnd($input)
    {
        return $this->GoogleApiKeyRepository->allGoogleApiKeyFrontndList($input);
    }
    /**
     * @param $id
     * @return mixed
     */
    public function deleteGoogleApiKey($id)
    {
        return $this->GoogleApiKeyRepository->delete($id);
    }


    /**
     * @param $input
     * @return false|mixed
     */
    public function googleApiKeyCustomInsert($input)
    {
        $output['google_api_key'] = $input['google_api_key'];
        $output['status'] = $input['status'];
        $output['created_by'] = Auth::id();
        $output['created_at'] = Carbon::now();
        return $this->storeGoogleApiKey($output);
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function googleApiKeyCustomUpdate($input, $id)
    {
        $output['google_api_key'] = $input['google_api_key'];
        $output['status'] = $input['status'];
        $output['updated_by'] = Auth::id();
        $output['updated_at'] = Carbon::now();
        return $this->updateGoogleApiKey($output, $id);
    }
}
