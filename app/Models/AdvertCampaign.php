<?php

namespace App\Models;

use App\Enums\MediaCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AdvertCampaign extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * Registers media collections
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(MediaCollection::BANNER)
            ->singleFile();
    }

    /**
     * Indicates custom attributes to append to model.
     *
     * @var array
     */
    public $appends = ['banner_images'];

    /**
     * Get full URL for the advert_campaigns' banner images.
     *
     * @return string
     */
    public function getBannerImagesAttribute()
    {
        return $this->getFirstMediaUrl(MediaCollection::BANNER);
    }
}
