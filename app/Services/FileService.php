<?php

namespace App\Services;

use Intervention\Image\ImageManager;

class FileService
{
    public function updateImage($model, $request)
    {
        $manager = ImageManager::gd();
        $image = $manager->read($request->file('image'));

        if(!empty($model->image)) {
            $currentImage = public_path() . $model->image;

            if(file_exists($currentImage) && $currentImage != public_path() . '/user-placeholder.png') {
                unlink($currentImage);
            }
        }

        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();

        $image->crop($request->width, $request->height, $request->left, $request->top);

        $name = time() . '.' . $extension;
        $image->save(public_path() . '/files/' . $name);
        $model->image = '/files/' . $name;

        return $model;
    }

    public function addVideo($model, $request)
    {
        $file = $request->file('video');
        $extension = $file->getClientOriginalExtension();
        $name = time() . '.' . $extension;
        $file->move(public_path() . '/files/', $name);
        $model->video = '/files/' . $name;

        return $model;
    }
}
