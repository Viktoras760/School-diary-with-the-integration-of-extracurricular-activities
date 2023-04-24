<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $table = 'school';

    protected $primaryKey = 'id_School';

    protected $fillable = [
        'name',
        'address',
        'pupilAmount',
        'teacherAmount'
    ];

    public $timestamps=false;

    public function classrooms()
    {
        return $this->belongsToMany('App\Models\Classroom', 'fk_Schoolid_School', 'fk_Classroomid_Classroom');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'id_User', 'fk_Userid_User');
    }
}
