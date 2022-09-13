<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    /**
     * Search query in multiple whereOr
     */
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('sender', 'like', '%'.$query.'%')
            ->orWhere('recipient', 'like', '%'.$query.'%')
            ->orWhere('origin_like', 'like', '%'.$query.'%')
            ->orWhere('destination_like', 'like', '%'.$query.'%')
            ->orWhere('cost', 'like', '%'.$query.'%')
            ;
    }
}
