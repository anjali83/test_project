<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\{User,Country};
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Http\Requests\RegisterRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    

    public function showRegistrationForm(){
        $data['countries'] = Country::orderBy('name')->get(['id','name']);        
        return view('auth.register',$data);
    }

    public function registerAction(RegisterRequest $request){
        
        $dob = '';
        if($request->dob){
            $dobDate = Carbon::parse($request->dob); 
            $dob = $dobDate->format('Y-m-d');
        }        

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile,
            'dob' => $dob,
            'gender' => $request->gender,
            'address' => $request->address,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'registered_by' => 'Manual',
            'role_id' => 2,
            'is_active' => 1,
        ]);
        
        $user_id = $user->id;
        $user_name_slug = Str::of($user->name)->slug('_');
        $upload_folder = $user_name_slug.'_'.$user_id;

        $profile_photo = $document = '';

        $profileFilePath = "public/uploads/profile/$upload_folder";
        $documentFilePath = "public/uploads/document/$upload_folder";

        if(!Storage::exists($profileFilePath)){
          Storage::makeDirectory($profileFilePath, 0775, true, true);
        }

        if(!Storage::exists($documentFilePath)){
            Storage::makeDirectory($documentFilePath, 0775, true, true);
          }
               

        if ($request->hasFile('profile_photo')) {
          if($request->file('profile_photo')->isValid()){
              $file = $request->file('profile_photo');             
              $profile_photo =  $fileName = $file->getClientOriginalName();                             
                   
              Storage::putFileAs($profileFilePath,$file,$fileName);              
            
          }
        }

        if ($request->hasFile('document')) {
            if($request->file('document')->isValid()){
                $file = $request->file('document');             
                $document =  $fileName = $file->getClientOriginalName();
                Storage::putFileAs($documentFilePath,$file,$fileName); 
            }
          }

        $user->profile_photo = $profile_photo;
        $user->document = $document;
        $user->save();


         Auth::login($user);
         return redirect('/')->with('success','Welcome To Dashboard!');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);      
    }
}
