<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
  use HasFactory, Notifiable;

  protected $table = 'user';

  protected $primaryKey = 'id_User';

  protected $fillable = [
    'name',
    'surname',
    'personalCode',
    'email',
    'grade',
    'password',
    'speciality',
    'iat',
    'role',
    'confirmation',
    'cv',
    'fk_Schoolid_School',
    'fk_Classid_Class',
  ];

  protected $hidden = [
      'iat',
      'remember_token'
  ];


  /**
   * Get the identifier that will be stored in the subject claim of the JWT.
   *
   * @return mixed
   */
  public function getJWTIdentifier()
  {
      return $this->getKey();
  }

  /**
   * Return a key value array, containing any custom claims to be added to the JWT.
   *
   * @return array
   */
  public function getJWTCustomClaims()
  {
      return [
          'Users id' => $this->id_User,
          'role' => $this->role,
      ];
  }

  public $timestamps=true;

  public function school()
  {
      return $this->hasOne('App\Models\School', 'id_School', 'fk_Schoolid_School');
  }

  public function lessons()
  {
      return $this->belongsToMany('App\Models\Lesson', 'user_lesson', 'fk_Userid_User', 'fk_Lessonid_Lesson');
  }
  public function class1()
  {
    return $this->belongsTo('App\Models\ClassModel', 'fk_Classid_Class', 'id_Class');
  }
  public function role1()
  {
    return $this->belongsTo('App\Models\Role', 'role', 'id_Role');
  }
  public function confirmation()
  {
    return $this->belongsTo('App\Models\Confirmation', 'confirmation', 'id_Confirmation');
  }
  public function userLessons()
  {
    return $this->hasMany('App\Models\UserLesson', 'fk_Userid_User', 'id_User');
  }
  public function teachingClass()
  {
    return $this->hasMany('App\Models\ClassModel', 'classTeacherId', 'id_User');
  }

}
