<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manifest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transit_destination_id',
        'package_destination_id',
        'quantity',
        'weight',
        'volume',
        'type',
        'cod',
        'cost',
    ];

    // Relationships
    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function transitDestination()
    {
        return $this->belongsTo(TransitDestination::class);
    }
}
