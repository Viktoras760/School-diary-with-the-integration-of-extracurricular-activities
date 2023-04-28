<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainLessons extends Model
{
  use HasFactory;

  protected $table = 'MainLessons';

  protected $primaryKey = 'id_mainLessons';

  protected $fillable = [
    'name',
    'lessonsType',
    'fk_Classid_Class',
  ];

  protected $hidden = [
  ];

  public $timestamps=false;

  public function classModel()
  {
    return $this->belongsTo('App\Models\ClassModel', 'fk_Classid_Class', 'id_Class');
  }

  public function lessons()
  {
    return $this->hasMany('App\Models\Lesson', 'fk_mainLessonsid_mainLessons', 'id_mainLessons');
  }
}
