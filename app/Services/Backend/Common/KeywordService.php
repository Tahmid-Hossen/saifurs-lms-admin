<?php

namespace App\Services\Backend\Common;

use App\Repositories\Backend\Common\KeywordRepository;
use App\Services\UtilityService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

/**
 * Class KeywordService
 * @package App\Services\Backend\Common
 */
class KeywordService
{
    /**
     * @var KeywordRepository
     */
    private $keywordRepository;

    /**
     * KeywordService constructor.
     * @param KeywordRepository $keywordRepository
     */
    public function __construct(KeywordRepository $keywordRepository)
    {

        $this->keywordRepository = $keywordRepository;
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function updateKeyword($input, $id)
    {
        try {
            $keyword = $this->keywordRepository->find($id);
            $this->keywordRepository->update($input, $id);
            return $keyword;
        } catch (ModelNotFoundException $e) {
           \Log::error('Keyword not found');
        } catch (Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function showKeywordByID($id)
    {
        return $this->keywordRepository->find($id);
    }

    /**
     * @param $input
     * @return mixed
     */
    public function ShowAllKeyword($input)
    {
        return $this->keywordRepository->KeywordFilterData($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteKeyword($id)
    {
        return $this->keywordRepository->delete($id);
    }

    /**
     * @return array
     */
    public function getKeywordDropDown(): array
    {
        $keywords = [];
        foreach ($this->keywordRepository->allKeyword() as $keyword) {
            $keywords[$keyword->keyword_id] = $keyword->keyword_name;
        }
        return $keywords;
    }

    /**
     * @param array $inputs
     * @return array
     */
    public function getAllKeywordId($inputs): array
    {
        if ($inputs != null) {
            $exitsKeywords = [];

            foreach ($inputs as $input) {
                if (is_numeric($input))
                    $exitsKeywords[] = (int)$input;
                else {
                    if ($keyword = $this->storeKeyword([
                            'keyword_name' => $input,
                            'Keyword_status' => \Utility::$statusText[1]]
                    )) {
                        $exitsKeywords[] = $keyword->keyword_id;
                    }
                }
            }

            return array_unique($exitsKeywords);
        } else {
            return [];
        }
    }

    /**
     * @param array $input
     *
     * @return mixed
     */
    public function storeKeyword(array $input)
    {
        try {
            return $this->keywordRepository->create($input);
        } catch (Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }
}
