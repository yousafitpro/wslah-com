<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstagramStory extends Model
{
    use HasFactory;
    protected $table = 'instagram_stories';
    protected $guarded = [];
}
