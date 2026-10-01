<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyUnit extends Model
{
    protected $fillable = [
        'property_id', 'unit_type', 'size_sqft', 'bedrooms', 'bathrooms',
        'balconies', 'parking_spaces', 'floor_plan_image', 'price', 'is_available', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
            'size_sqft' => 'decimal:2',
            'price' => 'decimal:2',
        ];
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
