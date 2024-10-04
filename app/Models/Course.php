<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'Cosename',
        'Cosefile',
        'datestart',
        'dateend',
    ];

    // Define the relationship to the users
    public function responsibles()
    {
        return $this->hasMany(Responsible::class);
    }

    // Define the relationship to directly access users
    public function users()
    {
        return $this->belongsToMany(User::class, 'responsibles');
    }
    public function regists()
    {
        return $this->belongsToMany(Regist::class, 'course_regist', 'course_id', 'regist_id');
    }

    // public function projects()
    // {
    //     return $this->belongsToMany(Project::class, 'course_projects')->using(CourseProject::class);
    // }
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'course_projects');
    }
}
