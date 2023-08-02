<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;
    protected $table = 'curriculums';
    protected $primaryKey = 'id';
    protected $fillable = ['department_id', 'user_id', 'name', 'images', 'status', 'size', 'vote', 'view', 'description'];
}
