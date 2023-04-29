<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLesson extends Model
{
  use HasFactory;

  protected $table = 'user_lesson';

  protected $primaryKey = 'id_user_lesson';

  protected $fillable = [
    'mark',
    'comment',
    'Attended',
    'fk_Lessonid_Lesson',
    'fk_Userid_User'
  ];

  public $timestamps=false;

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'fk_Userid_User', 'id_User');
  }

  public function lesson()
  {
    return $this->belongsTo('App\Models\Lesson', 'fk_Lessonid_Lesson', 'id_Lesson');
  }
}
