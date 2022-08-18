<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory,SoftDeletes;
    public $timestamps = true;

    protected $guarded = [];

    public function states(){
        return $this->belongsTo(State::class);
    }

    /**
     * Interact with the cities state name
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function state(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                if($this->state_id){
                    $details = State::find($this->state_id);
                   return $details->name;
                }else{         
                    return null;
                }
            }
        );
    }

    /**
     * Interact with the cities country name
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function Country(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                if($this->country_id){
                    $details = Country::find($this->country_id);                   
                   return $details->name;
                }else{                   
                    return null;
                }
            }
        );
    }
}
