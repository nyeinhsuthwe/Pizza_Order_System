<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Storage;

class AdminController extends Controller
{
    protected $fillable = ['id','name','email','password','image','phone','address','role'];

    public function changePassword(){
        return view('admin.password.changePassword');
    }

    //change Password
    public function change(Request $request){

        $this->passwordValidationCheck($request);

        $user = User::select('password')->where('id', Auth::user()->id)->first();
        $dbHashValue= $user->password;

        if(Hash::check($request->oldPassword, $dbHashValue)){
            $data = [
            'password'=> Hash::make($request-> newPassword)
            ];
            User::where('id', Auth::user()->id)->update($data);
            // Auth::logout();
            return back()->with(['changeSuccess'=>'Password has been Changed!']);
        }
        return back()->with(['notMatch'=>'Old Password Incorrect']);
    }

    //password validation
    public function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword'=>'required|min:6',
            'newPassword'=>'required|min:6',
            'confirmPassword'=>'required|min:6',
        ])->validate();
    }

    //for account info

    public function accountInfo(){
        return view('admin.account.details');
    }

    //for admin List
    public function adminList(){
        $admin = User::when(request('search'), function($query){
            $query->orWhere('name','like','%'. request('search').'%')
                  ->orWhere('email','like','%'. request('search').'%')
                  ->orWhere('address','like','%'. request('search').'%')
                  ->orWhere('phone','like','%'. request('search').'%');
        })
        ->where('role','admin')->paginate(3);
        $admin->appends(request()->all());
        return view('admin.account.adminList',compact('admin'));
    }
    //for admin delete
    public function adminDelete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Admin account has been Deleted!']);
    }

    public function editInfo(){
        return view('admin.account.profileEdit');
    }

    public function changeRole($id){
        $account = User::where('id',$id)->first();
        return view('admin.account.changeRole', compact('account'));
    }

    public function changeR($id, Request $request){
        $data = $this->getRequestData($request);
        User::where('id',$id)->update($data);
        return redirect()->route('adminList');
    }

    private function getRequestData($request){
        return [
            'role'=> $request->role
        ];
    }

    //update account info
    public function updateInfo($id, Request $request){
        $this->accountValidationCheck($request);
        $data = $this -> getUserData($request);

        //for image
        if($request->hasFile('image')){
            //to get old pic
            $dbImage= User::where('id', $id)->first();
            $dbImage = $dbImage->image;

            //check image
            if($dbImage != null){
                Storage::delete('public/'.$dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/', $fileName);
            $data['image'] =  $fileName;
        }

        User::where('id',$id)->update($data);
        return redirect()->route('accountInfo')->with(['updateSuccess'=>'Admin info has been Updated!']);
    }

    // request user data
    private function getUserData($request){
        return[
            'name'=> $request->name,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'address'=> $request->address,
            'updated_at'=> Carbon::now(),
        ];
    }

    //account validation
    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name'=> 'required',
            'email'=> 'required',
            'phone'=> 'required',
            'address'=> 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ])->validate();
    }

}
