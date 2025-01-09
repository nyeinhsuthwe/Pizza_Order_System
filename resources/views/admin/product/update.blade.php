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
                            <div class="ms-5">
                                <i class="fa-solid fa-arrow-left" onclick="history.back()"></i>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Edit Product</h3>
                            </div>
                            <hr>
                            <form action="{{route('updateProduct', $pizza->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-4 offset-1">
                                    <div class=" img-thumbnail shadow-sm">

                                        <img src="{{ asset('storage/' . $pizza->image) }}" >

                                    </div>

                                    <div>
                                        <input type="file" name="pizzaImage" id="pizzaId" class="form-control mt-1">
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-dark text-white col-12" type="submit"><i class="fa-solid fa-arrow-up-from-bracket me-1"></i>Update</button>
                                    </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label  class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="pizzaName"  value="{{old('pizzaName', $pizza->name)}}" type="text"  class="form-control @error('pizzaName') is-invalid
                                            @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Your pizzaName">

                                            @error('pizzaName')
                                                <small class="invalid-feedback">
                                                {{$message}}
                                                </small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1">Price</label>
                                            <input id="cc-pament" name="pizzaPrice"  value="{{old('pizzaPrice', $pizza->price)}}" type="text" class="form-control @error('pizzaPrice') is-invalid
                                            @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Your pizzaPrice">
                                            @error('pizzaPrice')
                                            <small class="invalid-feedback">
                                                {{$message}}
                                            </small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1">Category</label>
                                            <select name="pizzaCategory" id="" class="form-control">
                                                <option value="">Choose Your Category</option>
                                                @foreach ( $category as $c )
                                                    <option value="{{$c->id}}" @if ($pizza->category_id == $c->id) @selected(true) @endif>{{$c->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1">Description</label>
                                            <input id="cc-pament" name="pizzaDescription"  value="{{old('pizzaDescription', $pizza->description)}}" type="text" class="form-control @error('pizzaDescription') is-invalid
                                            @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Your pizzaDescription">

                                            @error('pizzaDescription')
                                            <small class="invalid-feedback">
                                                {{$message}}
                                            </small>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1">View Count</label>
                                            <input name="viewCount" type="text"  id="" class="form-control" value="{{old('viewCount',$pizza->view_count)}}">
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1">Created_at</label>
                                            <input id="cc-pament" name="date"  value="{{$pizza->created_at->format('j-F-Y')}}" type="text" class="form-control" aria-required="true" aria-invalid="false" >
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
