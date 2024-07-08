<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
