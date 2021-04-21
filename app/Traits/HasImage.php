<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Storage;

trait HasImage
{
    protected static function bootHasImage()
    {
        static::deleting(function ($model) {
            $model->deleteImage();
        });
    }

    public function updateImage(UploadedFile $image)
    {
        tap($this->image_path, function ($previous) use ($image) {
            $this->forceFill([
                'image_path' => $image->storePublicly('foods', 'public'),
            ])->save();

            if ($previous) {
                Storage::disk('public')->delete($previous);
            }
        });
    }

    public function deleteImage()
    {
        Storage::disk('public')->delete($this->image_path);

        $this->forceFill([
            'image_path' => null,
        ])->save();
    }

    public function getImageUrlAttribute()
    {
        return $this->image_path
        ? Storage::disk('public')->url($this->image_path)
        : Storage::disk('public')->url('/default.png');
    }
}
