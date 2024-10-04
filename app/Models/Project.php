<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'Projectname',
        'Projectfile',
        'iduser',
        'Projectdetail',
        'tcas',
        'year',
        'status',
    ];
    // public function courses()
    // {
    //     return $this->belongsToMany(Course::class, 'course_projects')->using(CourseProject::class);
    // }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_projects');
    }
}
