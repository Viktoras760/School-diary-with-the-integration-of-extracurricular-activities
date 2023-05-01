<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
  use HasFactory;

  protected $table = 'class';

  protected $primaryKey = 'id_Class';

  protected $fillable = [
    'name',
    'grade',
    'classTeacherId',
  ];

  protected $hidden = [
  ];

  public $timestamps=false;

  public function users()
  {
    return $this->hasMany('App\Models\User', 'fk_Classid_Class', 'id_Class');
  }

  public function teacher()
  {
    return $this->hasOne('App\Models\User', 'id_User', 'classTeacherId');
  }

  public function mainlessons()
  {
    return $this->hasMany('App\Models\MainLessons', 'fk_Classid_Class', 'id_Class');
  }

  public function getAllLessons()
  {
    $mainLessons = $this->mainlessons;
    $allLessons = [];

    foreach ($mainLessons as $mainLesson) {
      $lessons = $mainLesson->lessons;
      foreach ($lessons as $lesson) {
        $allLessons[] = $lesson;
      }
    }

    return $allLessons;
  }
}
