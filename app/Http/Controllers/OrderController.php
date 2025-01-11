<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function adminOrderList(){
        $order = Order::select('orders.*','users.name as user_name')
                ->leftJoin('users','users.id','orders.user_id')
                ->orderBy('created_at','desc')
                ->get();
        return view('admin.order.orderlist', compact('order'));
    }

    public function sortStatus(Request $request){

        $order = Order::select('orders.*','users.name as user_name')
                ->leftJoin('users','users.id','orders.user_id')
                ->orderBy('created_at','desc');

                if($request->status == 3 ){
                    $order = $order->get();
                }else{
                    $order = $order->where('orders.status', $request->status)->get();
                }

                return response()->json($order,200);
    }
}
