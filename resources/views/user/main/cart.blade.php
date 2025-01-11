@extends('user.layout.master')

@section('content')
<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach ( $cartList as $c)
                    <tr>
                        <td class="align-middle"><img src="{{asset('storage/'. $c->pizza_image)}}" alt="" style="width: 50px; height: 40px"></td>
                        <td class="align-middle"> {{$c->pizza_name}}</td>
                        <input type="hidden" class="product_id" value="{{$c->product_id}}">
                        <input type="hidden" class="order_id" value="{{$c->order_id}}">
                        <input type="hidden" class="user_id" value="{{$c->user_id}}">
                    </td>
                        <td class="align-middle" id="price">{{$c->pizza_price}} Ks</td>
                        <td class="align-middle">
                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-minus" >
                                    <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" id="qty" value={{$c->quantity}}>
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-plus">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle" id="total">{{$c->pizza_price * $c->quantity}} Ks</td>
                        <td class="align-middle"><button class="btn btn-sm btn-danger" id="removeBtn"><i class="fa fa-times"></i></button></td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Sub Total</h6>
                        <h6 id="subTotalPrice">{{$totalPrice}} Ks</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Delivery fees</h6>
                        <h6 class="font-weight-medium">3000 Ks</h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5 id="finalPrice">{{$totalPrice+3000}} Ks</h5>
                    </div>
                    <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" id="orderBtn">Proceed To Checkout</button>
                    <button class="btn btn-block btn-danger font-weight-bold my-3 py-3" id="deleteBtn">Delete Your Cart</button>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Cart End -->
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function(){
            $('.btn-minus').click(function(){
                $parentNode = $(this).parents('tr');
                $price = Number($parentNode.find('#price').text().replace('Ks',''));
                $qty = Number($parentNode.find('#qty').val());
                $total = $price*$qty;
                $parentNode.find('#total').html( $total + ' Ks');

                summaryCalculation();
            })

            $('.btn-plus').click(function(){
                $parentNode = $(this).parents('tr');
                $price = Number($parentNode.find('#price').text().replace('Ks',''));
                $qty = Number($parentNode.find('#qty').val());
                 $total = $price*$qty;
                $parentNode.find('#total').html($total + ' Ks');

                summaryCalculation();
            })

            $('#removeBtn').click(function(){
                $parentNode = $(this).parents('tr');
                $productId = $parentNode.find('.product_id').val();
                $orderId = $parentNode.find('.order_id').val();

                $.ajax({
                        type : 'get',
                        url : 'http://localhost:8000/user/ajax/clear/recentlyCart',
                        data: {'productId' : $productId, 'orderId': $orderId},
                        dataType :'json',
                    })

                $parentNode.remove();
                summaryCalculation();
            })

            $('#deleteBtn').click(function(){
                    $('#dataTable tbody tr').remove();
                    $('#subTotalPrice').html('0 kyats');
                    $('#finalPrice').html('3000 kyats');

                    $.ajax({
                        type : 'get',
                        url : 'http://localhost:8000/user/ajax/clear/cart',
                        dataType :'json',
                    })
            })

            function summaryCalculation(){
                $totalPrice = 0;
                $('#dataTable tr').each(function(index,row){
                    $totalPrice += Number($(row).find('#total').text().replace('Ks',''));
                });

                $('#subTotalPrice').html(`${$totalPrice} Kyats`);
                $('#finalPrice').html(`${$totalPrice+3000} Kyats`);
            }

            $('#orderBtn').click(function(){
                $random = Math.floor(Math.random()*10001);
                $orderList = [];
                $('#dataTable tbody tr').each(function(index,row){
                    $orderList.push({
                        'user_id': $(row).find('.user_id').val(),
                        'product_id': $(row).find('.product_id').val(),
                        'qty': $(row).find('#qty').val(),
                        "total" : $(row).find('#total').text().replace('Ks','')*1,
                        'order_code' : '0000'+ $random,
                    })
                });
                console.log($orderList);

                $.ajax({
                type : 'get',
                data : Object.assign({}, $orderList),
                url : 'http://localhost:8000/user/ajax/order',
                dataType :'json',
                success : function(response){
                    if(response.status=='true'){
                        window.location.href ='http://localhost:8000/user/home'
                    }
                }
                })

            })
        })
    </script>
@endsection
