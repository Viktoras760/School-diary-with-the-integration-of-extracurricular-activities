<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confirmation extends Model
{
  use HasFactory;

  protected $table = 'confirmation';

  protected $primaryKey = 'id_Confirmation';

  protected $fillable = [
    'name',
  ];

  public $timestamps=false;

  public function users()
  {
    return $this->hasMany('App\Models\User', 'confirmation', 'id_Confirmation');
  }
}
