<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $table = 'lessons';
    protected $primaryKey = 'id';
    protected $fillable = ['curriculum_id', 'name', 'lesson_link', 'question_group_link', 'status'];
}
