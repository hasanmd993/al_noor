<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConstructionUpdate extends Model
{
    protected $fillable = [
        'property_id', 'title', 'description', 'milestone',
        'progress_percentage', 'photos', 'update_date',
    ];

    protected function casts(): array
    {
        return [
            'photos' => 'array',
            'update_date' => 'date',
        ];
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
