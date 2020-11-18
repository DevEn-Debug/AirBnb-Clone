<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
  protected $fillable = [
    'user_id',
    'title',
    'type',
    'description',
    'photo_url',
    'price_at_night',
    'number_of_bed',
    'number_of_bathroom',
    'number_of_room',
    'mq',
    'address',
    'latitude',
    'longitude',
    'disactive',
    'deleted'
  ];

  public function visits()
  {
    return $this -> hasMany(Visit::class)->withPivot('id', 'flat_id', 'date', 'counter');
  }
  public function messages()
  {
    return $this -> hasMany(Message::class);
  }
  public function photos()
  {
    return $this -> hasMany(Photo::class);
  }





  public function sponsors()
  {
    return $this -> belongsToMany(Sponsor::class)->withTimestamps()-> withPivot('id','sponsor_id','flat_id','date_end')->orderBy('id','desc');

  }
  public function services()
  {
    return $this -> belongsToMany(Service::class)-> withPivot('id','service_id','flat_id');
  }

  public function user()
  {
    return $this -> belongsTo(User::class);
  }

}
