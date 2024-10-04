<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseProject extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'project_id',
    ];
    public $timestamps = true;
}
