<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manifest extends Model
{
    use HasFactory;

    // Relationships
    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function transitDestination()
    {
        return $this->belongsTo(TransitDestination::class);
    }

    public function packageDestination()
    {
        return $this->belongsTo(PackageDestination::class);
    }
}
