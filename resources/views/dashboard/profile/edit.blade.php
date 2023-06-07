@extends('layouts.dashboard')
@section('inside-content')
    <div class="container">
        <form action="{{ route('home.saveProfile') }}" method="post" class="col-md-6 offset-md-3">
            <a href="{{ route('home') }}" class="btn btn-mine my-2">&leftarrow;</a>            
            <h5 class="fs-2">Edit Admin profile</h5>
            @csrf
            
            <label for="email">Admin Email</label>
            <input type="email" name="email" id="email" class="form-control mb-2" value="{{ $user->email }}" required>
            <div class="text-danger">
                @error('email')
                    {{ $message }}
                @enderror
            </div>

            <label for="password">Admin password</label>
            <input type="password" name="password" id="password" class="form-control mb-2" minlength="6" minlength="10"
                required>
            <div class="text-danger">
                @error('password')
                    {{ $message }}
                @enderror
            </div>

            <label for="password">confirm password</label>
            <input type="password" name="c_password" id="c_password" class="form-control mb-2">
            <div class="text-danger">
                @error('c_password')
                    {{ $message }}
                @enderror
            </div>

            <input type="submit" value="save profile" class="btn btn-mine">
        </form>
    </div>
@endsection
