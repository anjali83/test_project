<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use HasFactory,SoftDeletes;
    public $timestamps = true;

    protected $guarded = [];

    public function cities(){
        return $this->hasMany(City::class);
    }

    public function countries(){
        return $this->belongsTo(Country::class);
    }

    /**
     * Interact with the dsc's first name and last name.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function country(): Attribute
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
