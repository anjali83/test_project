<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function redirectPath()
    {
        if(Auth::check() && (Auth::user()->role_id == 1 )){
            return route('admin'); 
        }
        
        return route('home');
        
    }

    protected function authenticated(Request $request, $user)
    {
           if(Auth::user()->role_id == '1'){
            
                   return redirect()->route('admin');   

            }elseif(Auth::user()->role_id == '2'){

                return redirect()->route('home');   
          }
   }

   

    protected function credentials(Request $request)
    {   
        $user = User::whereEmail($request->email)->first();
       
        if(empty($user)){
            return ['email' => 'notexist', 'password' => $request->password, 'is_active' => 1];
        }elseif($user->is_active == 0){
            return ['email' => 'inactive', 'password' => 'Your account is In-active. Please contact to Admin Person.'];
        }else{
            return ['email' => $request->{$this->username()}, 'password' => $request->password, 'is_active' => 1];
        }
        //return ['email' => $request->{$this->username()}, 'password' => $request->password, 'is_active' => 1];
        
    }
   

   protected function sendFailedLoginResponse(Request $request)
   {
        $details = $this->credentials($request);

        if($details['email'] == 'notexist'){
            throw ValidationException::withMessages([            
                $this->username() => [trans('auth.failed')],
            ]);
        }elseif($details['email'] == 'inactive'){
            throw ValidationException::withMessages([            
                'message' => 'Your account is In-active. Please contact to Admin Person.',
            ]);
        }        

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
            'password' => [trans('auth.password')],
        ]);
   }

   /**
    * Handle Social login request
    *
    * @return response
    */
    public function socialLogin($social)
    {
        return Socialite::driver($social)->redirect();
    }
    /**
     * Obtain the user information from Social Logged in.
     * @param $social
     * @return Response
     */
    public function SocialLoginAction($social)
    {
        try {
            $userSocial = Socialite::driver($social)->user();
            $user = User::where(['email' => $userSocial->getEmail()])->first();
            if($user){
                Auth::login($user);           
                return redirect()->intended('/');
            }else{
                if($social == 'facebook'){ $registered_by = 'Facebook';}else{$registered_by = 'Google';}
                $newUser = User::updateOrCreate(['email' => $user->email],[
                        'name' => $user->name,
                        'mobile' => $user->mobile,
                        'registered_by'=> $registered_by,
                        'password' => encrypt(rand(8))
                    ]);
        
                Auth::login($newUser);
        
                return redirect()->intended('dashboard');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
   
}
