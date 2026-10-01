<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Property extends Model
{
    protected $fillable = [
        'name', 'short_description', 'description', 'location_id', 'category_id',
        'address', 'status', 'type', 'land_area', 'land_unit', 'total_floors',
        'apartments_per_floor', 'total_units', 'price_from', 'price_to', 'price_label',
        'progress_percentage', 'launch_date', 'expected_completion', 'handover_date',
        'is_featured', 'is_special_offer', 'is_published', 'featured_image', 'video_url',
        'brochure_pdf', 'amenities', 'nearby_landmarks', 'latitude', 'longitude',
        'sort_order', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'amenities' => 'array',
            'nearby_landmarks' => 'array',
            'is_featured' => 'boolean',
            'is_special_offer' => 'boolean',
            'is_published' => 'boolean',
            'launch_date' => 'date',
            'expected_completion' => 'date',
            'handover_date' => 'date',
            'published_at' => 'datetime',
            'price_from' => 'decimal:2',
            'price_to' => 'decimal:2',
            'land_area' => 'decimal:2',
        ];
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(PropertyUnit::class)->orderBy('sort_order');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    public function constructionUpdates(): HasMany
    {
        return $this->hasMany(ConstructionUpdate::class)->orderByDesc('update_date');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeSpecialOffer($query)
    {
        return $query->where('is_special_offer', true);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'upcoming' => 'Upcoming',
            'ongoing' => 'Ongoing',
            'completed' => 'Completed',
            'handed_over' => 'Handed Over',
            default => ucfirst($this->status),
        };
    }
}
