<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderList;

class OrderController extends Controller
{
    public function adminOrderList(){
        $order = Order::select('orders.*','users.name as user_name')
                ->leftJoin('users','users.id','orders.user_id')
                ->orderBy('created_at','desc')
                ->get();
        return view('admin.order.orderlist', compact('order'));
    }

    //sort with ajax
    public function sortStatus(Request $request){
        $order = Order::select('orders.*','users.name as user_name')
                ->leftJoin('users','users.id','orders.user_id')
                ->orderBy('created_at','desc');

                if($request->status == null ){
                    $order = $order->get();
                }else{
                    $order = $order->where('orders.status', $request->status)->get();
                }

                return view('admin.order.orderlist', compact('order'));
    }

    public function changeStatus(Request $request){
        Order::where('id', $request->orderId)->update([
            'status'=> $request->status
        ]);

        $order = Order::select('orders.*','users.name as user_name')
        ->leftJoin('users','users.id','orders.user_id')
        ->orderBy('created_at','desc')
        ->get();

        return response()->json($order,200);
    }

    //order code
    public function orderInfo($orderCode){
        $orderList = OrderList::select('order_lists.*', 'users.name as user_name' , 'products.name as product_name', 'products.image as product_image')
        ->leftJoin('users','users.id','order_lists.user_id')
        ->leftJoin('products','products.id','order_lists.product_id')
        ->where('order_code', $orderCode)
        ->get();
        return view('admin.order.list', compact('orderList'));
    }
}
