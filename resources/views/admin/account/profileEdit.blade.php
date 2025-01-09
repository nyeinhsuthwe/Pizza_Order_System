@extends('admin.layouts.app')
@section('title','Category Page')
@section('content')


    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Edit Admin Info</h3>
                            </div>
                            <hr>
                            <form action="{{route('updateInfo', Auth::user()->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-4 offset-1">
                                    <div class=" img-thumbnail shadow-sm">
                                        @if (Auth::user()->image==null)
                                            <img src="{{asset('admin/images/icon/defaultUser.jfif')}}"  />
                                        @else
                                        <img src="{{ asset('storage/' . Auth::user()->image) }}" >
                                        @endif
                                    </div>

                                    <div>
                                        <input type="file" name="image" id="image" class="form-control mt-1">
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-dark text-white col-12" type="submit"><i class="fa-solid fa-arrow-up-from-bracket me-1"></i>Update</button>
                                    </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label  class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="name"  value="{{old('name', Auth::user()->name)}}" type="text"  class="form-control @error('name') is-invalid
                                            @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Your Name">

                                            @error('name')
                                                <small class="invalid-feedback">
                                                {{$message}}
                                                </small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1">Email</label>
                                            <input id="cc-pament" name="email"  value="{{old('email', Auth::user()->email)}}" type="text" class="form-control @error('email') is-invalid
                                            @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Your email">
                                            @error('email')
                                            <small class="invalid-feedback">
                                                {{$message}}
                                            </small>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1">Phone</label>
                                            <input id="cc-pament" name="phone"  value="{{old('phone', Auth::user()->phone)}}" type="text" class="form-control @error('phone') is-invalid
                                            @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Your Phone">

                                            @error('phone')
                                            <small class="invalid-feedback">
                                                {{$message}}
                                            </small>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1">Address</label>
                                            <textarea name="address"  id="" class="form-control @error('address') is-invalid
                                            @enderror" cols="30" rows="10" placeholder="Enter your Address">{{old('address', Auth::user()->address)}}</textarea>

                                            @error('address')
                                                <small class="invalid-feedback">
                                                {{$message}}
                                                </small>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1">Role</label>
                                            <input id="cc-pament" name="role"  value="{{old('role', Auth::user()->role)}}" type="text" class="form-control" aria-required="true" aria-invalid="false" disabled>
                                        </div>

                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
@endsection
