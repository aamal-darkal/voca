@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <div class="row">            
            <form action="{{ route('levels.update' , ['level'=> $level]) }}" method="post" class="col-md-6 offset-md-3">
                @csrf
                @method('put')

                <h4>Edit Level </h4>

                <div class="control-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title' , $level->title) }}" placeholder="Level title"
                        required maxlength="100" class="form-control my-2" maxlength="255">
                    <div class="text-danger">
                        @error('title')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="control-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" value="{{ old('description' , $level->description) }}"
                        placeholder="Level description" required maxlength="100" class="form-control my-2" maxlength="255">
                    <div class="text-danger">
                        @error('description')
                            {{ $message }}
                        @enderror
                    </div>
                </div>                
               
                <input type="submit" value="save Level" class="btn btn-mine btn-mine mt-1">
                <input type="reset" value="تصفير" class="btn btn-outline-mine mt-1">
                <a href="{{ route('levels.index') }}" class="btn btn-outline-secondary my-2">تراجع</a>
            </form>
        </div>
    </div>
@endsection