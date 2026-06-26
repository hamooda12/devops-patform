<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scenario extends Model
{
    protected $fillable = [
        'title',
        'description',
        'difficulty',
        'points',
        
    ];

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}