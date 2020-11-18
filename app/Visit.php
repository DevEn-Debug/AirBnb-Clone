<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
  protected $fillable = [
    'flat_id',
    'date',
    'counter'
  ];
  public function flat()
  {
    return $this -> belongsTo(Flat::class);
  }
}
