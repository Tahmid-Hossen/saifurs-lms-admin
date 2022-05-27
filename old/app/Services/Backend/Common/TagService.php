<?php

namespace App\Services\Backend\Common;

use App\Repositories\Backend\Common\TagRepository;
use App\Services\UtilityService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

/**
 * Class KeywordService
 * @package App\Services\Backend\Common
 */
class TagService
{
    /**
     * @var TagRepository
     */
    private $tagRepository;

    /**
     * TagService constructor.
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {

        $this->tagRepository = $tagRepository;
    }

    /**
     * @param array $input
     *
     * @return mixed
     */
    public function storeTag(array $input)
    {
        try {
            return $this->tagRepository->create($input);
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
    public function updateTag($input, $id)
    {
        try {
            $tag = $this->tagRepository->find($id);
            $this->tagRepository->update($input, $id);
            return $tag;
        } catch (ModelNotFoundException $e) {
            Log::error('Tag not found');
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
    public function showTagByID($id)
    {
        return $this->tagRepository->find($id);
    }

    /**
     * @param $input
     * @return mixed
     */
    public function ShowAllTag($input)
    {
        return $this->tagRepository->allTagList($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteTag($id)
    {
        return $this->tagRepository->delete($id);
    }

    /**
     * @return array
     */
    // public function getTagDropDown(): array
    // {
    //     $tags = [];
    //     foreach($this->tagRepository->allTag() as $tag) {
    //         $tags[$tag->id] = $tag->tag_name;
    //     }
    //     return $tags;
    // }

    /**
     * @param array $inputs
     * @return array
     */

    public function getAllTagId(array $inputs): array
    {
        $exitsTags = [];

        foreach ($inputs as $input) {
            if (is_numeric($input))
                $exitsTags[] = (int)$input;
            else {
                if ($tag = $this->storeTag([
                        'tag_name' => $input,
                        'tag_status' => UtilityService::$statusText[1]]
                )) {
                    $exitsTags[] = $tag->id;
                }
            }
        }

        return array_unique($exitsTags);
    }
}
