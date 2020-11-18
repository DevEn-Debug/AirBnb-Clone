<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
  protected $fillable = [
    'flat_id',
    'photo_url'
  ];
  public function flat()
  {
    return $this -> belongsTo(Flat::class);
  }
}
