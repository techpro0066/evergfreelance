<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    public function modules()
    {
        return $this->hasMany(CourseModule::class);
    }

    public function buyCourses()
    {
        return $this->hasMany(BuyCourse::class);
    }
}
