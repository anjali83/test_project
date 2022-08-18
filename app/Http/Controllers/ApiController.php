<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Response;
use App\Models\{Country,State,City};
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function fetchCountry()
    {
        $data['countries'] = Country::get(["name", "id"]);
        return view('welcome', $data);
    }
    public function fetchState(Request $request)
    {     
        $data['states'] = [];
        if($request->country_id){
             $data['states'] = Country::find($request->country_id)->states;
        }
        return response()->json($data);
    }
    public function fetchCity(Request $request)
    {    
        $data['cities'] = [];  
        if($request->state_id){
            $data['cities'] = State::find($request->state_id)->cities;
        }
        return response()->json($data);
    }     
}
