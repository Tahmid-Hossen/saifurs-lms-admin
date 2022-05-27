<?php

namespace App\Services\Backend\Blog;

use App\Repositories\Backend\Blog\BlogRepository;
use App\Services\FileUploadService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Utility;

class BlogService
{
    /**
     * @var BlogRepository
     */
    private $blogRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * @param BlogRepository $blogRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(BlogRepository $blogRepository, FileUploadService $fileUploadService)
    {
        $this->blogRepository = $blogRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createBlog($input)
    {
        try {
            return $this->blogRepository->create($input);
        } catch (ModelNotFoundException $e) {
            \Log::error('Blog not found');
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function updateBlog($input, $id)
    {
        try {
            $company = $this->blogRepository->find($id);
            $this->blogRepository->update($input, $id);
            $company->fresh();
            return $company;
        } catch (ModelNotFoundException $e) {
            \Log::error('Blog not found');
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteBlog($id)
    {
        return $this->blogRepository->delete($id);
    }

    /**
     * @param $input
     * @return Builder
     */
    public function showAllBlog($input): Builder
    {
        return $this->blogRepository->blogFilterData($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function blogById($id)
    {
        return $this->blogRepository->find($id);
    }

    /**
     * @param $input
     * @return string|null
     */
    public function blogLogo($input): ?string
    {
        $data['image'] = $input->file('blog_logo');
        $data['image_name'] = 'blog_logo_' . $input['blog_id'];
        $data['destination'] = Utility::$imageUploadPath['blog_logo'];
        $data['width'] = Utility::$blogLogoSize['width'];
        $data['height'] = Utility::$blogLogoSize['height'];
        $image = $this->fileUploadService->savePhoto($data);
        return $image;
    }
}
