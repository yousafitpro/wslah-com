<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_coming_soon',
        'coming_soon_date',
        'coming_soon_time',
        'store_id'
    ];
}
