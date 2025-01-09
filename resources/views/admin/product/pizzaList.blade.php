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
                                <h2 class="title-1">Product List</h2>

                            </div>
                        </div>
                        <form action="{{route('productList')}}" method="get" >
                            @csrf
                            <div class="table-data__tool">
                                <input class="au-input au-input--xl" type="text" value="{{request('search')}}" name="search" placeholder="Search ..." />
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </div>
                        </form>
                        <div class="table-data__tool-right">
                            <a href="{{route('createPizza')}}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add products
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>

                    @if (session('createSuccess'))
                    <div class="col-4 offset-8">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{session('createSuccess')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                      </div>
                    @endif

                    @if (session('deleteSuccess'))
                    <div class="col-4 offset-8">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{session('deleteSuccess')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                      </div>
                    @endif

                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr class="tr-shadow">
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>View Count</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $pizza as $p)
                                <tr class="tr-shadow" style="margin-bottom: 3px">
                                    <td class="col-3"><img src="{{asset('storage/'.$p->image)}}" class="shadow-sm img-thumbnail"></td>
                                    <td class="col-3">{{$p->name}}</td>
                                    <td class="col-2">{{$p->price}} Ks</td>
                                    <td class="col-2">{{$p->category_name}}</td>
                                    <td class="col-2">{{$p->view_count}}</td>
                                    <td class="col-2 ">
                                        <div class="table-data-feature ">
                                            <a href="{{route('updatePage',$p->id)}}" class="me-2">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </button>
                                            </a>
                                            <a href="{{route('editProduct', $p->id)}}" class="me-2">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="More">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            </a>
                                            <a href="{{route('delete',$p->id)}}">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            </a>

                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{$pizza->links()}}
                        </div>
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
@endsection
