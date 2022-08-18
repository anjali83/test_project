<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StateRequest;
use Carbon\Carbon;
use App\Models\{Country,State};
use Auth;

class StateController extends Controller
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
        $data['list'] = State::orderBy('name')->paginate($perPage);      
        return view('admin.state.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $data['countries'] = Country::orderBy('name')->get(["name", "id"]);
        return view('admin.state.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StateRequest $request)
    {
        $state = new State;
        $state->name = $request->name;
        $state->country_id = $request->country_id;
        $state->save();

        return redirect('admin/state')->with('message', 'State Has Been Added');
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
        if($data['details'] = State::findOrFail($id)){      
            $data['countries'] = Country::orderBy('name')->get(["name", "id"]);      
            return view('state.edit',$data);
        }else{
            return redirect('admin/state')->with('message', 'Invalid Id!');
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
            'name' => ['required', 'string', 'max:255', "unique:states,name,{$id}"],
            'country_id' => 'required',           
          ]);  

        if($state = State::findOrFail($id)){ 
            $state->name = $request->name;
            $state->country_id = $request->country_id;
            $state->save();

            return redirect('admin/state')->with('message', 'State Has Been Updated');
        }else{
            return redirect('admin/state')->with('message', 'Invalid Id!');
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
        $country = Country::findOrFail($id);        
        $country->delete(); 
        return redirect('admin/state')->with('message', 'State Has Been Deleted');  
    }
}
