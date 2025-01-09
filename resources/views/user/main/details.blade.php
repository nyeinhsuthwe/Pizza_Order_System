@extends('user.layout.master')

@section('content')

    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">

        <div class="ms-5 mb-3">
            <a href="{{route('userHomePage')}}"><i class="fa-solid fa-arrow-left text-dark "></i></a>
        </div>

        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <img class="w-100 h-100" src="{{asset('storage/'. $pizza->image)}}" alt="Image">
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <input type="hidden" class="form-control bg-secondary border-0 text-center" id="userId" value="{{Auth::user()->id}}">
                    <input type="hidden" class="form-control bg-secondary border-0 text-center" id="pizzaId" value="{{$pizza->id}}">
                    <h3>{{$pizza->name}}</h3>
                    <h3 class="font-weight-semi-bold mb-4">{{$pizza->price}} Ks</h3>
                    <p class="mb-4">{{$pizza->description}}</p>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary border-0 text-center" id="orderCount" value="1">

                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1" id="addCartBtn"></i> Add To Cart</button>
                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @foreach ( $pizzaList as $p)
                    <div class="product-item bg-light ">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100 " src="{{asset('storage/'. $p->image)}}" style="height:200px" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href="{{route('details', $p->id)}}"><i class="fa-solid fa-eye"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">{{$p->name}}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{$p->price}} Ks</h5>
                            </div>

                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->

@endsection

@section('scriptSource')
<script>
    $(document).ready(function(){
        $('#addCartBtn').click(function(){
            $count = $('#orderCount').val();
            $user = $('#userId').val();
            $pizza = $('#pizzaId').val();

            $source = {
                'userId' : $user,
                'pizzaId' : $pizza,
                'count' : $count
            };

            $.ajax({
                type : 'get',
                data : $source,
                url : 'http://localhost:8000/user/ajax/cart',
                dataType :'json',
                success : function(response){
                    if(response.status=='success'){
                        window.location.href ='http://localhost:8000/user/home'
                    }
                }

            })

        })
    })

</script>
@endsection
