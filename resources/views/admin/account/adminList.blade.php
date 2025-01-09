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
                                <h2 class="title-1">Admin List</h2>

                            </div>
                        </div>
                        <form action="{{route('adminList')}}" method="get" enctype="multipart/form-data">
                            @csrf
                            <div class="table-data__tool">
                                <input class="au-input au-input--xl" type="text" value="{{request('search')}}" name="search" placeholder="Search ..." />
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </div>
                        </form>
                        <div class="table-data__tool-right">
                            <a href="{{route('categoryCreate')}}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add category
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
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                    @foreach ($admin as  $a)
                                    <tr class="tr-shadow" style="margin-bottom: 3px">
                                        <td class="col-3">
                                        @if ($a->image==null)
                                           <img src="{{asset('admin/images/icon/defaultUser.jfif')}}"  class="img-thumbnail shadow-sm"/>
                                        @else
                                        <img src="{{asset('storage/'.$a->image)}}" class="shadow-sm img-thumbnail h-12"></td>
                                        @endif
                                        <td class="col-2">{{$a->name}}</td>
                                        <td class="col-3">{{$a->email}}</td>
                                        <td class="col-2">{{$a->address}}</td>
                                        <td class="col-3">{{$a->phone}}</td>
                                        <td>
                                        <div class="table-data-feature">
                                            @if (Auth::user()->id == $a->id)

                                            @else
                                            <a href="{{route('changeRole', $a->id)}}" class="me-2">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Role Change">
                                                    <i class="fa-solid fa-arrows-rotate me-2"></i>
                                                </button>
                                            </a>
                                            <a href="{{route('adminDelete', $a->id)}}" class="me-2">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="zmdi zmdi-delete me-2"></i>
                                                </button>
                                            </a>
                                            @endif
                                       </div>
                                    </td>
                                    </tr>
                                    @endforeach


                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{$admin->links()}}
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
