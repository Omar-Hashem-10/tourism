<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Trip extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    public $translatable = ['title', 'country', 'desc', 'highlights'];

    protected $fillable = [
        'title', 'country', 'desc', 'highlights', 'highlight_images',
        'price', 'currency', 'duration',
        'category', 'climate', 'travel_type', 'budget_tier',
        'color_from', 'color_to', 'is_egyptian',
        'spots_total', 'spots_left', 'departure_dates',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'travel_type'      => 'array',
        'departure_dates'  => 'array',
        'highlight_images' => 'array',
        'is_egyptian'      => 'boolean',
        'is_active'        => 'boolean',
        'price'            => 'decimal:2',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile();

        $this->addMediaCollection('flag')
            ->singleFile();

        $this->addMediaCollection('gallery');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('image');
    }
}
