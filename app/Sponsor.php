<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
  protected $fillable = [
    'cost',
    'duration'
  ];
  public function flats()
  {
    return $this -> belongsToMany(Flat::class)->withTimestamps()-> withPivot('id','sponsor_id','flat_id','date_end')->orderBy('id','desc');
  }
}
