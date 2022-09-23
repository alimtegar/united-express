<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id',
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

    public function sender()
    {
        return $this->belongsTo(Sender::class);
    }
}
