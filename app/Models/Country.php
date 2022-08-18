<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $table = 'Countries';

    public $timestamps = true;

    protected $guarded = [];

    public function states(){
        return $this->hasMany(State::class);
    }

    public function stateCity()
    {
        return $this->hasOneThrough(
            State::class, 
            City::class,
            'country_id', // Foreign key on the states table...
            'state_id', // Foreign key on the cities table...
            'id', // Local key on the countries table...
            'id' // Local key on the states table...
        );
    }
}
