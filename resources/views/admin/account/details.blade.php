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
                            <div class="card-title">
                                <h3 class="text-center mt-3 title-2">Account Info</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 offset-2 img-thumbnail shadow-sm">
                                    @if (Auth::user()->image==null)
                                    <img src="{{asset('admin/images/icon/defaultUser.jfif')}}"  />
                                    @else
                                    <img src="{{ asset('storage/' . Auth::user()->image) }}" />
                                    @endif
                                </div>
                                <div class="col-5 offset-1">
                                    <h4 class="my-3 text-muted fs-6"><i class="fa-solid fa-user-pen me-2"></i> Name : {{Auth::user()->name}}</h4>
                                    <h4 class="my-3 text-muted fs-6"> <i class="fa-solid fa-envelope me-2"></i> Email : {{Auth::user()->email}}</h4>
                                    <h4 class="my-3 text-muted fs-6"> <i class="fa-solid fa-phone me-2"></i> Phone : {{Auth::user()->phone}}</h4>
                                    <h4 class="my-3 text-muted fs-6"> <i class="fa-solid fa-location-dot me-2"></i> Address : {{Auth::user()->address}}</h4>
                                    <h4 class="my-3 text-muted fs-6"> <i class="fa-solid fa-clock me-2"></i> Join Date : {{Auth::user()->created_at->format("j-F-Y")}}</h4>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-4 offset-6 ">
                                    <a href="{{route('editInfo')}}">
                                        <button class="btn btn-dark text-white" type="submit">
                                            <i class="fa-solid fa-pen-to-square me-2"></i>Edit Profile
                                        </button>
                                    </a>
                                </div>
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
