@extends('admin.layouts.app')
@section('title','Category Page')
@section('content')


    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <a href="{{route('adminOrderList')}}"><i class="fa-solid fa-arrow-left-long mb-3 text-black"></i></a>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr class="tr-shadow">
                                    <th></th>
                                    <th>User ID</th>
                                    <th>User Name</th>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Amount</th>
                                    <th>Order Date</th>
                                </tr>
                            </thead>
                            <tbody class="dataList">
                                @foreach ( $orderList as  $o)
                                    <tr class="tr-shadow">
                                        <td></td>
                                        <td>{{$o->user_id}}</td>
                                        <td>{{$o->user_name}}</td>
                                        <td><img src="{{asset('storage/'. $o->product_image)}}" class=" img-thumbnail" style="width:100px "></td>
                                        <td>{{$o->product_name}}</td>
                                        <td>{{$o->total+3000}}</td>
                                        <td>{{$o->created_at->format('F-j-Y')}}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
@endsection

