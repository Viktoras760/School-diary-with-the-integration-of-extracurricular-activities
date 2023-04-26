<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
  use HasFactory;

  protected $table = 'class1';

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

  public function mainlessons()
  {
    return $this->hasMany('App\Models\MainLessons', 'fk_Classid_Class', 'id_Class');
  }
}
