@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <div class="row">            
            <form action="{{ route('levels.update' , ['level'=> $level]) }}" method="post" class="col-md-6 offset-md-3">
                <a href="{{ route('levels.index' , ['domain' => $domain]) }}" class="btn btn-mine my-2">&leftarrow;</a>
                <h4>Edit Level </h4>
                @csrf
                @method('put')            

                <div class="control-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title' , $level->title) }}" placeholder="Level title"
                        class="form-control my-2" maxlength="100" required>
                    <div class="text-danger">
                        @error('title')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="control-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" value="{{ old('description' , $level->description) }}"
                        placeholder="Level description" class="form-control my-2" maxlength="255" required>
                    <div class="text-danger">
                        @error('description')
                            {{ $message }}
                        @enderror
                    </div>
                </div>                
                <div class="control-group">
                    <label for="order">Order</label>
                    <input type="number" name="order" value="{{ old('order' , $level->order) }}"
                        placeholder="Level order" required min=1 class="form-control my-2">
                    <div class="text-danger">
                        @error('order')
                            {{ $message }}
                        @enderror
                    </div>
                </div>                
               
                <input type="submit" value="save Level" class="btn btn-mine btn-mine mt-1">
                <input type="reset" value="تصفير" class="btn btn-outline-mine mt-1">
            </form>
        </div>
    </div>
@endsection
