@extends('admin.layouts.app')
@section('title','Category Page')
@section('content')


    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <a href="{{route('adminOrderList')}}"><i class="fa-solid fa-arrow-left-long mb-3 text-black"></i></a>
                    <div class="table-responsive table-responsive-data2">
                        <h5 class="mb-3 bg-white text-secondary col-2 text-center p-2 rounded">Total - {{$users->total()}}</h5>
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr class="tr-shadow">
                                    <th>User Image</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody class="dataList">
                                @foreach ( $users as  $user)
                                    <tr>
                                        <input type="hidden" name="userId" id="userId" value="{{$user->id}}">
                                        <td  class="col-2 img-thumbnail">
                                            @if ($user->image==null)
                                            <img src="{{asset('admin/images/icon/defaultUser.jfif')}}"  />
                                            @else
                                            <img src="{{ asset('storage/' . $user->image) }}" />
                                            @endif
                                        </td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->address}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td>
                                            <select name="" id="" class="form-control statusChange">
                                                <option value="user" @if ($user->role == 'user') @selected(true) @endif>User</option>
                                                <option value="admin" @if ($user->role == 'admin') @selected(true) @endif>Admin</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{$users->links()}}
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

@section('scriptSection')
<script>
 $(document).ready(function(){
     //change status
    $('.statusChange').change(function(){
        $currentStatus = $(this).val();
        $parentNode = $(this).parents('tr');
        $userId = $parentNode.find('#userId').val();

        $data = {
            'userId': $userId,
            'role': $currentStatus
        };

        $.ajax({
                type : 'get',
                data : $data,
                url : 'http://localhost:8000/admin/user/user/role',
                dataType :'json',
                success : function(response){
                }
        })
        location.reload();
 })
 })
</script>
@endsection


