<?php

namespace App\Http\Controllers;
use Storage;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;


class ProductController extends Controller
{
    function productList(){
        $pizza = Product::select('products.*','categories.name as category_name')
        ->when(request('search'), function($query){
                        $query->where('products.name','like','%'. request('search').'%');
                        })
                        ->leftJoin('categories','products.category_id','categories.id')
                        ->orderBy('products.created_at','desc')
                        ->paginate(3);
                        $pizza->appends(request()->all());
        return view('admin.product.pizzaList',compact('pizza'));
    }

    function createPizza(){
        $categories = Category::select('id','name')->get();
        return view('admin.product.create', compact('categories'));
    }

    function create(Request $request){
        $this->productValidationCheck($request,'create');
        $data = $this->requestProductInfo($request);

        if($request->hasFile('pizzaImage')){
            $fileName = uniqid().$request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public/',$fileName);
            $data['image'] = $fileName;
        }

        Product::create($data);
        return redirect()->route('productList');
    }

    private function requestProductInfo($request){
        return[
            'name'=> $request->pizzaName,
            'category_id'=> $request->pizzaCategory,
            'description'=> $request->pizzaDescription,
            'price'=> $request->pizzaPrice,
        ];
    }

    private function productValidationCheck($request, $action){
        $validationRules=[
            'pizzaName'=>'required|unique:products,name',
            'pizzaCategory'=>'required',
            'pizzaDescription'=>'required',
            'pizzaImage'=>'required|mimes:jpg,jpeg,png,webp|file',
            'pizzaPrice'=>'required',
        ];

        $validationRules['pizzaImage']= $action== 'create' ? 'required|mimes:jpg,jpeg,png,webp|file' : 'mimes:jpg,jpeg,png,webp|file';
        Validator::make($request->all(), $validationRules)->validate();
    }

    function delete($id){
        Product::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Product Deleted Successfully!']);
    }

    function editProduct($id){
        $pizza = Product::select('products.*','categories.name as category_name')
        ->leftJoin('categories','products.category_id','categories.id')
        ->where('products.id',$id)->first();
        return view('admin.product.edit', compact('pizza'));
    }

    function updatePage($id){
        $pizza = Product::where('id',$id)->first();
        $category = Category::get();
        return view('admin.product.update',compact('pizza','category'));
    }

    function updateProduct($id, Request $request){
        $this->productValidationCheck($request,'update');
        $data = $this->requestProductInfo($request);
        if($request->hasFile('pizzaImage')){
            //to get old pic
            $oldImageName= Product::where('id', $request->id)->first();
            $oldImageName = $oldImageName->image;

            //check image
            if($oldImageName != null){
                Storage::delete('public/'.$oldImageName);
            }

            $fileName = uniqid() . $request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public/', $fileName);
            $data['image'] =  $fileName;
        }

        Product::where('id',$request->id)->update($data);
        return redirect()->route('productList');
    }
}
