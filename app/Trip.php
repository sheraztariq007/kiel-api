<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class Trip extends Model
{
    use Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from','till', 'hotel_id', 'user_id','places_to_visit_ids'
    ];



    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function authUser(){
        return $this->user_id==Auth::user()->getAuthIdentifier();
    }
}
