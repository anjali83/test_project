<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    public $timestamps = true;

    protected $guarded = [];

    /**
     * Interact with the dsc's status.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                if($this->is_active == '1')
                    return 'Yes';
                else
                    return 'No';
               
            }           
        );
    }

    /**
     * Interact with the user's city name
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function city(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                if($value){
                    $details = City::find($value);
                   return $details->name;
                }else{         
                    return null;
                }
            }
        );
    }

    /**
     * Interact with the user's state name
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function state(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                if($value){
                    $details = State::find($value);
                   return $details->name;
                }else{         
                    return null;
                }
            }
        );
    }

    /**
     * Interact with the user's country name
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function country(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                if($value){
                    $details = Country::find($value);                   
                   return $details->name;
                }else{                   
                    return null;
                }
            }
        );
    }    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
