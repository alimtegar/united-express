<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

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
