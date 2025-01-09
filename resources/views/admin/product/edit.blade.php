@extends('admin.layouts.app')
@section('title','Category Page')
@section('content')


    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6 offset-7">
                        @if (session('updateSuccess'))
                        <div class="col-6 ">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{session('updateSuccess')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">

                                <div class="ms-5">
                                    <i class="fa-solid fa-arrow-left" onclick="history.back()"></i>
                                </div>

                            <div class="card-title">
                                <h3 class="text-center mt-3 title-2">Pizza Details</h3>
                            </div>
                            <hr>
                            <div class="row ">
                                <div class="col-5 offset-1">
                                    <img src="{{asset('storage/'.$pizza->image)}}"  />
                                </div>
                                <div class="col-4 offset-1">
                                    <div class="my-2 fs-6 btn btn-danger text-white">{{$pizza->name}}</div>
                                    <h4 class="my-3 text-muted fs-6"> <i class="fa-solid fa-money-bill-wave me-2 text-warning"></i> Price : {{$pizza->price}} Ks</h4>
                                    <h4 class="my-3 text-muted fs-6"> <i class="fa-solid fa-clone me-2 text-warning"></i> Category : {{$pizza->category_name}}</h4>
                                    <h4 class="my-3 text-muted fs-6"> <i class="fa-solid fa-eye me-2 text-warning"></i> View Count : {{$pizza->view_count}}</h4>
                                    <h4 class="my-3 text-muted fs-6"> <i class="fa-solid fa-clock me-2 text-warning"></i>Date : {{$pizza->created_at->format("j-F-Y")}}</h4>
                                </div>
                            </div>
                            <div class=" mx-5">
                                <h4 class="text-muted fs-6 mt-4 mb-2 ms-3"><i class="fa-solid fa-circle-info me-2 text-warning"></i> Description :</h4> <p class="text-muted fs-6 mt-0 ms-3">{{$pizza->description}}</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
@endsection
