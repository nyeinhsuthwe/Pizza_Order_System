@extends('user.layout.master')

@section('content')
<!-- Cart Start -->
<div class="container-fluid" style=" height:400px">
    <div class="row px-xl-5">
        <div class="col-lg-8 offset-2 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Date</th>
                        <th>Order ID</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                @foreach ( $order as $o)
                    <tr>
                        <td class="align-middle"> {{$o->created_at->format('F-j-Y')}}</td>
                        <td class="align-middle"> {{$o->order_code}}</td>
                        <td class="align-middle"> {{$o->total_price}}</td>
                        <td class="align-middle">
                            @if ($o->status == 0)
                                <span class="text-info">Pending</span>
                            @elseif ($o->status == 1)
                                <span class="text-success ">Success</span>
                            @elseif ($o->status == 2)
                                <span class="text-danger ">Reject</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
            <span class="mt-4">{{$order->links()}}</span>
        </div>

    </div>
</div>
<!-- Cart End -->
@endsection
