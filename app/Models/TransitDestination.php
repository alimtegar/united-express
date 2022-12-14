<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransitDestination extends Model
{
    use HasFactory;

    // Relationships
    public function manifests()
    {
        return $this->hasMany(Manifest::class);
    }
}
