<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryController extends Controller
{
    function list(){
        $categories = Category::when(request('search'), function($query){
            $query->where('name','like','%'. request('search').'%');
        })
        ->orderBy('id','desc')
        ->paginate(3);
        $categories->appends(request()->all());
        return view('admin.category.list', compact('categories'));
    }
    function createPage(){
        return view('admin.category.categoryCreate');
    }

    //create category
    function create(Request $request){
        $this-> categoryValidationCheck($request);
        $data = $this -> requestCategoryData($request);
        Category::create($data);
        return redirect()->route('categoryList')->with(['createSuccess'=>'Category Created Successfully!']);
    }

    //delete category
    function delete($id){
        Category::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Category Deleted Successfully!']);
    }

    //category edit
    function edit($id){
        $category = Category::where('id',$id)->first();
        return view('admin.category.edit', compact('category'));
    }

    function update(Request $request){
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::where('id',$request->categoryID)->update($data);
        return redirect()->route('categoryList');
    }



    //category validation check
    private function categoryValidationCheck($request){
        Validator::make($request->all(),[
            'categoryName'=>'required|unique:categories,name,'.$request->categoryID. ',id',
        ])->validate();
    }

    //request category data
    private function requestCategoryData($request){
        return[
            'name'=>$request->categoryName,
        ];

    }
}
