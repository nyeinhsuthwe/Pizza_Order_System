@extends('admin.layouts.app')
@section('title','Category Page')
@section('content')


    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->

                    <form action="{{route('sortStatus')}}" method="post">
                        @csrf
                        <div class="d-flex mb-3">
                            <select name="status" id="orderStatus" class="form-control statusChange col-2">
                                <option value="" >All</option>
                                <option value="0" @if(request('status')=='0') selected @endif >Pending</option>
                                <option value="1" @if(request('status')=='1') selected @endif >Success</option>
                                <option value="2" @if(request('status')=='2') selected @endif >Reject</option>
                            </select>
                            <button type="submit" class="btn bg-dark text-white sm ms-1">search</button>
                            <span for="" class="ms-1 p-2 text-white bg-dark rounded"><i class="fa-solid fa-basket-shopping"></i> Total - {{count($order)}}</span>
                        </div>
                    </form>

                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr class="tr-shadow">
                                    <th>User ID</th>
                                    <th>User Name</th>
                                    <th>Order Date</th>
                                    <th>Order Code</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="dataList">
                                @foreach ( $order as  $o)
                                    <tr class="tr-shadow">
                                        <input type="hidden" name="" class="orderId" value="{{$o->id}}">
                                        <td>{{$o->user_id}}</td>
                                        <td>{{$o->user_name}}</td>
                                        <td>{{$o->created_at->format('F-j-Y')}}</td>
                                        <td>
                                            <a href="{{route('orderInfo',$o->order_code)}}">{{$o->order_code}}</a>
                                        </td>
                                        <td>{{$o->total_price}}</td>
                                        <td>
                                            <select name="status" class="form-control statusChange statusChange">
                                                <option value="0"  >Pending</option>
                                                <option value="1" @if ($o->status==1) @selected(true) @endif >Success</option>
                                                <option value="2" @if ($o->status==2) @selected(true) @endif >Reject</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- <div class="mt-4">
                            {{$order->links()}}
                        </div> --}}
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
@endsection

@section('scriptSection')
    <script>
     $(document).ready(function(){
         //change status
        $('.statusChange').change(function(){
            $currentStatus = $(this).val();
            $parentNode = $(this).parents('tr');
            $orderId = $parentNode.find('.orderId').val();

            $data = {
                'status': $currentStatus,
                'orderId': $orderId
            };

            $.ajax({
                    type : 'get',
                    data : $data,
                    url : 'http://localhost:8000/admin/order/changeStatus',
                    dataType :'json',
                    success : function(response){

                    }

            })
     })
     })
    </script>
@endsection
