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
        'iat',
        'role',
        'confirmation',
        'CV',
        'fk_Schoolid_School',
        'creatorId'
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
}
