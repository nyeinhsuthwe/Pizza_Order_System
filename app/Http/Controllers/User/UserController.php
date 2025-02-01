<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Storage;
use Illuminate\Support\Carbon;
use App\Models\Cart;
use App\Models\Order;

class UserController extends Controller
{
    //direct user home page
    public function userHomePage(){
        $pizza = Product::orderBy('created_at', 'desc')->get();
        $category= Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $history = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('pizza','category','cart','history'));

    }

    //change password page
    public function changePassword(){
        return view('user.password.changePassword');
    }

    //change password
    public function changePasswordPage(Request $request){
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

    //account edit page
    public function accountEdit(){
        return view('user.account.accountEdit');
    }

    //category list
    public function categoryFilter($categoryId){
        $pizza = Product::where('category_id', $categoryId)->orderBy('created_at', 'desc')->get();
        $category= Category::get();
        $history = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('pizza','category','history'));
    }

    //pizza details pg
    public function details($pizzaId){
        $pizza = Product::where('id', $pizzaId)->first();
        $pizzaList = Product::get();
        return view('user.main.details', compact('pizza','pizzaList'));
    }

    //account edit
    public function accountUpdate($id, Request $request){
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
        return redirect()->route('accountEdit')->with(['updateSuccess'=>'Your Account info has been Updated!']);
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

    public function cartList(){
        $cartList = Cart::select('carts.*', 'products.name as pizza_name', 'products.price as pizza_price','products.image as pizza_image')
                  ->leftJoin('products','products.id','carts.product_id')
                  ->where('carts.user_id', Auth::user()->id)
                  ->get();

        $totalPrice = 0;
        foreach( $cartList as $c) {
            $totalPrice += $c->pizza_price * $c->quantity;
        }

        return view('user.main.cart', compact('cartList','totalPrice'));
    }

    public function orderHistory() {
        $order = Order::where('user_id', Auth::user()->id)->orderBy('created_at','desc')->paginate('6');
        return view ('user.main.history', compact('order'));
    }

    //direct user List page
    public function userList(){
        $users = User::where('role','user')->paginate(3);
        return view('admin.user.list', compact('users'));
    }

    //change user role
    public function userRole(Request $request){
        $updateSource = [
            'role' => $request->role
        ];

        User::where('id', $request->userId)->update($updateSource);
    }

}
