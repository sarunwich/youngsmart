<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsible extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'user_id',
        
    ];
     // Define the relationship to the user
     public function user()
     {
         return $this->belongsTo(User::class);
     }
 
     // Define the relationship to the course
     public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
