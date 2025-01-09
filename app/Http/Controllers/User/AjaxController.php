<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Carbon;
use App\Models\Cart;
use App\Models\OrderList;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    //return pizza list using ajax
    public function pizzaListAjax(Request $request){
        logger($request->all());
        if($request->status == 'desc'){
            $data = Product::orderBy('created_at', 'desc')->get();
        }
        else{
            $data = Product::orderBy('created_at', 'asc')->get();
        }
        return $data;
    }

    public function addToCart(Request $request){
       $data = $this-> getOrderData($request);
       Cart::create($data);
       $response = [
        'message'=> 'Add to Cart Completed',
        'status'=> 'success'

    ];
       return response()->json($response, 200);
    }

    public function orderList(Request $request){
        foreach( $request->all() as $item){
            OrderList::create([
                'user_id'=> $item['user_id'],
                'product_id'=> $item['product_id'],
                'qty'=> $item['pizzaqty'],
                'total'=> $item['total'],
                'order_code'=> $item['order_code'],
            ]);
        }
        Cart::where('user_id', Auth::user()->id)->delete();
        return response()->json([
            'status' => 'true'
        ], 200);
    }

    private function getOrderData($request){
        return [
            'user_id'=> $request->userId,
            'product_id'=> $request->pizzaId,
            'quantity'=> $request->count,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ];
    }
}
