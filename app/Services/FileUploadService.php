<?php

namespace App\Services;

use File;
use Image;
use Utility;

class FileUploadService
{
    /**
     * @param $file
     * @param $oldFileName
     * @return null|string
     */
    public function handleFileUpload($file, $oldFileName): ?string
    {
        $newFileName = $this->saveFile($file, UtilityService::$fileUploadPath);

        if ($newFileName) {
            // remove this
            $fileName_old = $oldFileName;
            $this->removeFile($fileName_old, UtilityService::$fileUploadPath);
        }

        return $newFileName;
    }

    /**
     * @param $file
     * @param $uploadPath
     * @return null|string
     */
    public function saveFile($file, $uploadPath): ?string
    {
        if (isset($file)) {
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $fileName);
            return $fileName;
        }
        return null;
    }

    /**
     * @param $file
     * @param $uploadPath
     * @return bool
     */
    public function removeFile($file, $uploadPath): bool
    {
        if (!$file) {
            return false;
        }

        $deleteOldImage = $uploadPath . '/' . $file;
        if (File::isFile($deleteOldImage)) {
            File::delete($deleteOldImage);
        }

        return true;
    }

    /**
     * @param $file
     * @param $oldFile
     * @param $filePath
     * @return null|string
     */
    public function replaceUploadedFile($file, $oldFile, $filePath)
    {
        $newFileName = $this->saveFile($file, $filePath);

        if ($newFileName) {
            // remove this
            if (File::isFile($oldFile)) {
                File::delete($oldFile);
            }
        }

        return $newFileName;
    }

    public function savePhoto($data)
    {
        if (isset($data['image'])) {
            $imageName = $data['image_name'] . '.' . strtolower($data['image']->getClientOriginalExtension());
             $destinationPath = public_path(UtilityService::$fileUploadPath . $data['destination']);

            if ($data['image']->getClientOriginalExtension() != 'svg') {
                $imageWidth = Image::make($data['image']->getRealPath())->width();
                $imageHeight = Image::make($data['image']->getRealPath())->height();

                if (isset($data['width']) && isset($data['height'])):
                    if ($imageWidth > $imageHeight):
                        $width = $data['width'];
                        $height = $data['height'];
                    else:
                        $width = $data['height'];
                        $height = $data['width'];
                    endif;
                else:
                    $width = $imageWidth;
                    $height = $imageHeight;
                endif;

                $img = Image::make($data['image']->getRealPath())->resize($width, $height);
                $img->orientate();
                $this->removeFile($imageName, $destinationPath);
                $img->save($destinationPath . $imageName, 80);
                //$img->encode('png');
            } else {
                $data['image']->disk(config('filesystems.default'))->move($destinationPath, $imageName);
            }
            return '/' . $data['destination'] . $imageName;
        }

        return null;
    }

    /**
     * @param $data
     * @return null|string
     */
    public function saveFiles($data): ?string
    {

        if(isset($data['file'])) {
            $fileName = (isset($data['file_name'])?$data['file_name'].'_':null).time() . '.' . $data['file']->getClientOriginalExtension();
            $uploadPath = public_path($data['destination']);

            $data['file']->move($uploadPath, $fileName);
            return '/'.$data['destination'].$fileName;
        }
        return null;
    }
}
