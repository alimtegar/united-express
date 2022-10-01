<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'manifest_id',
        'invoice_id',
        'tracking_no',
        'recipient',
        'quantity',
        'weight',
        'volume',
        'type',
        'cod',
        'description',
        'cost',
    ];

    /**
     * Search query in multiple whereOr
     */
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::query()
            ->where('tracking_no', 'like', '%'.$query.'%')
            ->orWhere('recipient', 'like', '%'.$query.'%')
            ->orWhere('description', 'like', '%'.$query.'%')
            ;
    }


    // Relationships
    public function manifest()
    {
        return $this->belongsTo(Manifest::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function packageDestination()
    {
        return $this->belongsTo(PackageDestination::class);
    }
}
