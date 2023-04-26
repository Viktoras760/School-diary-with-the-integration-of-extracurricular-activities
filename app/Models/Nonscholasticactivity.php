<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nonscholasticactivity extends Model
{
  use HasFactory;

  protected $table = 'nonscholasticactivity';

  protected $primaryKey = 'id_nonscholasticActivity';

  protected $fillable = [
    'name',
    'price',
    'description',
  ];

  protected $hidden = [
  ];

  public $timestamps=false;

  public function lessons()
  {
    return $this->hasMany('App\Models\Lesson', 'fk_nonscholasticActivityid_nonscholasticActivity', 'id_nonscholasticActivity');
  }

}
