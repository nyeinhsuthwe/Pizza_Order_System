@extends('user.layout.master')

@section('content')
    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <div class="bg-light p-4 mb-30 shadow-md">
                    <form>
                        <div class=" d-flex px-3 py-2 align-items-center shadow-sm justify-content-between bg-dark text-white">
                            <label for="price-all">Category</label>
                            <span class="badge border font-weight-normal">{{count($category)}}</span>
                        </div>
                        <div class=" d-flex align-items-center justify-content-between shadow-sm mb-3 mt-3">
                            <a class="text-dark" href="{{route('userHomePage')}}">
                                <label  for="price-all">All</label>
                            </a>
                        </div>
                        @foreach ( $category as $c)
                        <div class=" d-flex align-items-center justify-content-between shadow-sm mb-3 mt-3">
                            <a class="text-dark" href="{{route('categoryFilter', $c->id)}}">
                                <label  for="price-all">{{$c->name}}</label>
                            </a>
                        </div>

                        @endforeach

                    </form>
                </div>
                <!-- Price End -->

                <div >
                    <button class="btn btn btn-warning w-100">Order</button>
                </div>

            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <a href="{{route('cartList')}}">
                                <div>
                                    <button class="btn btn-sm btn-dark text-white"><i class="fa fa-shopping-cart"></i> {{ isset($cart) && is_countable($cart) ? count($cart) : 0 }}</button>
                                </div>
                            </a>
                            <div class="ml-2">
                                <div class="btn-group">
                                    <select name="sorting" id="sortingOption" class="form-control">
                                        <option value="">Sorting</option>
                                        <option value="desc">Recently Update</option>
                                        <option value="asc">Previously Update</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div id="dataList" class="row">
                        @foreach ($pizza as $p)
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                         <div class="product-item bg-light mb-4" id="myForm">
                             <div class="product-img position-relative overflow-hidden">
                                 <img class="img-fluid w-100" style="height: 200px" src="{{ asset('storage/'. $p->image)}}" alt="">
                                 <div class="product-action">
                                     <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                     <a class="btn btn-outline-dark btn-square" href="{{route('details', $p->id)}}"><i class="fa-solid fa-eye"></i></a>
                                 </div>
                             </div>
                             <div class="text-center py-4">
                                 <a class="h6 text-decoration-none text-truncate" href="">{{ $p->name}}</a>
                                 <div class="d-flex align-items-center justify-content-center mt-2">
                                     <h5>{{$p->price}} Ks</h5>
                                 </div>
                                 <div class="d-flex align-items-center justify-content-center mb-1">
                                     <small class="fa fa-star text-primary mr-1"></small>
                                     <small class="fa fa-star text-primary mr-1"></small>
                                     <small class="fa fa-star text-primary mr-1"></small>
                                     <small class="fa fa-star text-primary mr-1"></small>
                                     <small class="fa fa-star text-primary mr-1"></small>
                                 </div>
                             </div>
                         </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>

    </div>
    <!-- Shop End -->
@endsection

@section('scriptSource')
<script>
    $(document).ready(function(){
        $('#sortingOption').change(function(){
            $evenOption = $('#sortingOption').val();
            if($evenOption == 'asc'){
                $.ajax({
                type : 'get',
                data : {'status':'asc'},
                url : 'http://localhost:8000/user/ajax/pizza/list',
                dataType :'json',
                success : function(response){
                    $list ='';
                    foreach($i=0, $i<response.length,$i++)
                        $list += `
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                         <div class="product-item bg-light mb-4" id="myForm">
                             <div class="product-img position-relative overflow-hidden">
                                 <img class="img-fluid w-100" style="height: 200px" src="{{ asset('storage/${response[$i].image}')}}" alt="">
                                 <div class="product-action">
                                     <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                     <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-eye"></i></a>
                                 </div>
                             </div>
                             <div class="text-center py-4">
                                 <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                 <div class="d-flex align-items-center justify-content-center mt-2">
                                     <h5>${response[$i].price} Ks</h5>
                                 </div>
                                 <div class="d-flex align-items-center justify-content-center mb-1">
                                     <small class="fa fa-star text-primary mr-1"></small>
                                     <small class="fa fa-star text-primary mr-1"></small>
                                     <small class="fa fa-star text-primary mr-1"></small>
                                     <small class="fa fa-star text-primary mr-1"></small>
                                     <small class="fa fa-star text-primary mr-1"></small>
                                 </div>
                             </div>
                         </div>
                        </div>
                        `;

                     console.log($list);

                     $('#dataList').html($list);
                }

            })
            }else if($evenOption == 'desc'){
                $.ajax({
                type : 'get',
                data : {'status':'desc'},
                url : 'http://localhost:8000/user/ajax/pizza/list',
                dataType :'json',
                success : function(response){
                    $list ='';
                    foreach($i=0, $i<response.length,$i++)
                        $list += `
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                         <div class="product-item bg-light mb-4" id="myForm">
                             <div class="product-img position-relative overflow-hidden">
                                 <img class="img-fluid w-100" style="height: 200px" src="{{ asset('storage/${response[$i].image}')}}" alt="">
                                 <div class="product-action">
                                     <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                     <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-eye"></i></a>
                                 </div>
                             </div>
                             <div class="text-center py-4">
                                 <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                 <div class="d-flex align-items-center justify-content-center mt-2">
                                     <h5>${response[$i].price} Ks</h5>
                                 </div>
                                 <div class="d-flex align-items-center justify-content-center mb-1">
                                     <small class="fa fa-star text-primary mr-1"></small>
                                     <small class="fa fa-star text-primary mr-1"></small>
                                     <small class="fa fa-star text-primary mr-1"></small>
                                     <small class="fa fa-star text-primary mr-1"></small>
                                     <small class="fa fa-star text-primary mr-1"></small>
                                 </div>
                             </div>
                         </div>
                        </div>
                        `;

                     $('#dataList').html($list);
                }
            })
            }

        });
    })

</script>
@endsection
