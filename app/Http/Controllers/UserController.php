<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\{User,Country,State,City};
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function _construct()
    {
        $this->middleware(['admin','auth']);
    }

    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data['users'] = User::whereRoleId('2')->orderBy('id','desc')->paginate(15);
        return view('admin.users.index', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($data['user'] = User::findOrFail($id)){  
            return view('admin.users.view',$data);
        }else{
            return redirect('user')->with('message', 'Invalid Id!');
        }
    }

    public function download($id,$type){
        
          $user = User::find($id);
          $user_name_slug = Str::of($user->name)->slug('_');
          $upload_folder = $user_name_slug.'_'.$user->id;

          if($type == 'document'){
            $file_name = $user->document;
            $file_path = "public/uploads/document/$upload_folder/".$file_name;
          }else{
            $file_name = $user->profile_photo;
            $file_path = "public/uploads/profile/$upload_folder/".$file_name;
          }
         
          
          $mimeType = Storage::mimeType($file_name);
  
        if (!Storage::has($file_path)) {
            abort(404);
        }
  
          $file = Storage::get($file_path);
        
          return response()->make($file, 200, array(
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'attachment; filename="' . $file_name . '"'
         ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);        
        $user->delete();  
        return redirect('admin/user')->with('message', 'User Has Been Deleted');  
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        $user = User::findOrFail($request->id);
        if($user){
          $user->is_active = $request->status;
          $user->save();
        }
  
        return response()->json(['success'=>'Status changed successfully.']);
    }
          
    
}
