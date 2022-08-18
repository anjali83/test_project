<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CityRequest;
use Carbon\Carbon;
use App\Models\{Country,City};
use Auth;

class CityController extends Controller
{
    public function _construct()
    {
        $this->middleware(['admin','auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $perPage = 10;
        $data['list'] = City::orderBy('name')->paginate($perPage);      
        return view('admin.city.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['countries'] = Country::orderBy('name')->get(["name", "id"]);
        return view('admin.city.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {
        $city = new City;
        $city->name = $request->name;
        $city->state_id = $request->state_id;
        $city->country_id = $request->country_id;
        $city->save();

        return redirect('admin/city')->with('message', 'City Has Been Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if($data['details'] = City::findOrFail($id)){      
            $data['countries'] = Country::orderBy('name')->get(["name", "id"]);      
            return view('admin.city.edit',$data);
        }else{
            return redirect('admin/city')->with('message', 'Invalid Id!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([           
            'name' => ['required', 'string', 'max:255', "unique:cities,name,{$id}"],
            'state_id' => 'required',           
          ]);  

        if($city = City::findOrFail($id)){ 
            $city->name = $request->name;
            $city->state_id = $request->state_id;
            $city->country_id = $request->country_id;
            $city->save();

            return redirect('admin/city')->with('message', 'City Has Been Updated');
        }else{
            return redirect('admin/city')->with('message', 'Invalid Id!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);        
        $city->delete(); 
        return redirect('admin/city')->with('message', 'City Has Been Deleted');  
    }
}
