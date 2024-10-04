<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Project;

class Regist extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'project',
        'course',
        
        'link',
        'facebook',
        'line',
        'stdpic',
        'school_record',
        'dateup_sr',
        'payment',
        'dateup_p',
        'std_status',
        'guidance_teacher',
        'portfolio_file',
    ];
    public function course() {
        return $this->belongsToMany(Course::class,);
   }
   public function project() {
    return $this->belongsToMany(Project::class,);
}
}
