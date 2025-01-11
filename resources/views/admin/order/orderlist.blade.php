@extends('admin.layouts.app')
@section('title','Category Page')
@section('content')


    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order List</h2>

                            </div>
                        </div>
                        <div class="overview-wrap">
                            <h2  class="title-1"><i class="fa-solid fa-basket-shopping"></i> Total - {{count($order)}}</h2>
                        </div>
                    </div>

                    <div class="d-flex mb-3">
                        <label for="" class="mt-2 me-3">Order Status:</label>
                        <select name="status" id="orderStatus" class="form-control col-2">
                            <option value="3"  >All</option>
                            <option value="0"  >Pending</option>
                            <option value="1"  >Success</option>
                            <option value="2"  >Reject</option>
                        </select>
                    </div>

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
                                        <td>{{$o->user_id}}</td>
                                        <td>{{$o->user_name}}</td>
                                        <td>{{$o->created_at->format('F-j-Y')}}</td>
                                        <td>{{$o->order_code}}</td>
                                        <td>{{$o->total_price}}</td>
                                        <td>
                                            <select name="status" class="form-control">
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
        $('#orderStatus').change(function(){
            $status = $('#orderStatus').val();
            $.ajax({
                type : 'get',
                data : {'status':$status},
                url : 'http://localhost:8000/admin/order/sortStatus',
                dataType :'json',
                success : function(response){
                    $list ='';
                    for($i=0;$i<response.length;$i++){
                        $list += `
                        <tr class="tr-shadow">
                            <td>${response[$i].user_id}</td>
                            <td>${response[$i].user_name}</td>
                            <td>${response[$i].created_at}->format('F-j-Y')</td>
                            <td>${response[$i].order_code}</td>
                            <td>${response[$i].total_price}</td>

                            <td>
                                <select name="status" class="form-control">
                                    <option value="0" ${response[$i].status} >Pending</option>
                                    <option value="1" ${response[$i].status} >Success</option>
                                    <option value="2" ${response[$i].status}>Reject</option>
                                </select>
                            </td>
                        </tr>
                        `;
                    }

                     $('#dataList').html($list);
                }

            })
        })
     })
    </script>
@endsection
