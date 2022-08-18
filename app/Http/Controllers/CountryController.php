<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CountryRequest;
use Carbon\Carbon;
use App\Models\{Country};
use Auth;

class CountryController extends Controller
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
        $data['list'] = Country::orderBy('name')->paginate($perPage);      
        return view('admin.country.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {      
        return view('admin.country.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryRequest $request)
    {
        $country = new Country;
        $country->name = $request->name;
        $country->save();

        return redirect('admin/country')->with('message', 'Country Has Been Added');
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
        if($data['details'] = Country::findOrFail($id)){            
            return view('admin.country.edit',$data);
        }else{
            return redirect('admin/country')->with('message', 'Invalid Id!');
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
            'name' => ['required', 'string', 'max:255', "unique:countries,name,{$id}"],           
          ]);  

        if($country = Country::findOrFail($id)){ 
            $country->name = $request->name;
            $country->save();

            return redirect('admin/country')->with('message', 'Country Has Been Updated');
        }else{
            return redirect('admin/country')->with('message', 'Invalid Id!');
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
        return redirect('admin/country')->with('message', 'Country Has Been Deleted');  
    }
}
