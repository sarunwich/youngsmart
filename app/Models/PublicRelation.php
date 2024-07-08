<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicRelation extends Model
{
    use HasFactory;
    protected $fillable = [
        'pr_title',
        'pr_detail',
        'pr_date',
        'pr_file',
        'pr_staus',
        'id_admin',
    ];
}
