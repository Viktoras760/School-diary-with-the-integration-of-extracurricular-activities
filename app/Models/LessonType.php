<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonType extends Model
{
  use HasFactory;

  protected $table = 'lessontype';

  protected $primaryKey = 'id_lessonType';

  protected $fillable = [
    'name',
  ];

  public $timestamps=false;

  public function lessons()
  {
    return $this->hasMany('App\Models\Lesson', 'type', 'id_lessonType');
  }
}
