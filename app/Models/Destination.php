<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Destination extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    public $translatable = ['name', 'description'];

    protected $fillable = [
        'name', 'description',
        'category', 'is_featured', 'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile();
    }

    public function getImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('image');
    }
}
