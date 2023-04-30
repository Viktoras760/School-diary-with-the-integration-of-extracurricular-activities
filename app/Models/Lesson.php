<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
  use HasFactory;

  protected $table = 'lesson';

  protected $primaryKey = 'id_Lesson';

  protected $fillable = [
    'lessonName',
    'lessonsStartingTime',
    'lessonsEndingTime',
    'lowerGradeLimit',
    'upperGradeLimit',
    'type',
    'fk_nonscholasticActivityid_nonscholasticActivity',
    'fk_Classroomid_Classroom',
    'fk_mainLessonsid_mainLessons',
    'creatorId'
  ];

  protected $hidden = [
      'fk_Classroomid_Classroom',
      'creatorId'
  ];

  public $timestamps=false;

  public function classroom()
  {
      return $this->hasOne('App\Models\Classroom', 'id_Classroom', 'fk_Classroomid_Classroom');
  }

  public function users()
  {
      return $this->belongsToMany('App\Models\User', 'user_lesson', 'fk_Lessonid_Lesson', 'fk_Userid_User');
  }

  public function creator()
  {
    return $this->hasOne('App\Models\User', 'id_User','creatorId');
  }

  public function mainLessons()
  {
    return $this->belongsTo('App\Models\MainLessons', 'fk_mainLessonsid_mainLessons', 'id_mainLessons');
  }

  public function nonscholasticactivity()
  {
    return $this->belongsTo('App\Models\Nonscholasticactivity', 'fk_nonscholasticActivityid_nonscholasticActivity', 'id_nonscholasticActivity');
  }
  public function type()
  {
    return $this->belongsTo('App\Models\LessonType', 'type', 'id_lessonType');
  }
  public function userLessons()
  {
    return $this->hasMany('App\Models\UserLesson', 'fk_Lessonid_Lesson', 'id_Lesson');
  }
}
