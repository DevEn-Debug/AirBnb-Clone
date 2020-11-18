<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  protected $fillable = [
    'flat_id',
    'name',
    'email',
    'subject',
    'message'
  ];
  public function flat()
  {
    return $this -> belongsTo(Flat::class);
  }
}
