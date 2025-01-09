@extends('layouts.master')

@section('content')
<div class="login-form">
    <form action="{{route('register')}}" method="post">
        @csrf
        <div class="form-group">
            <label>Username</label>
            <input class="au-input au-input--full" type="text" value="{{old('name')}}" name="name" placeholder="Username">
            @error('name')
            <small class="text-danger mt-2">{{$message}}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Email</label>
            <input class="au-input au-input--full" value="{{old('email')}}" type="email" name="email" placeholder="Email">
            @error('email')
            <small class="text-danger mt-2">{{$message}}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input class="au-input au-input--full" value="{{old('phone')}}" type="text" name="phone" placeholder="Phone">
            @error('phone')
            <small class="text-danger mt-2">{{$message}}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Address</label>
            <input class="au-input au-input--full" value="{{old('address')}}" type="text" name="address" placeholder="Address">
            @error('address')
            <small class="text-danger mt-2">{{$message}}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
            @error('password')
            <small class="text-danger mt-2">{{$message}}</small>
            @enderror
        </div>


        <div class="form-group">
            <label>Confirm Password</label>
            <input class="au-input au-input--full" type="password" name="password_confirmation" placeholder="Confirm Password">
            @error('password_confirmation')
            <small class="text-danger mt-2">{{$message}}</small>
            @enderror
        </div>

        <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">register</button>

    </form>
    <div class="register-link">
        <p>
            Already have account?
            <a href="{{route('authLogin')}}">Sign In</a>
        </p>
    </div>
</div>
@endsection
