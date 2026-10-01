<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'subject', 'property_interest', 'message', 'source', 'is_read'];

    protected function casts(): array
    {
        return ['is_read' => 'boolean'];
    }
}
