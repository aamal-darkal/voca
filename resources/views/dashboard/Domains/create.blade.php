@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <div class="row">            
            <form action="{{ route('domains.store') }}" method="post" class="col-md-6 offset-md-3">
                <a href="{{ route('domains.index') }}" class="btn btn-mine my-2">&leftarrow;</a>
                <h4>Add Domain </h4>
                @csrf
                <div class="control-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Domain title"
                         class="form-control my-2" maxlength="100" required>
                    <div class="text-danger">
                        @error('title')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="control-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" value="{{ old('description') }}"
                        placeholder="Domain description" class="form-control my-2" maxlength="255" required>
                    <div class="text-danger">
                        @error('description')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                

                <div class="control-group">
                    <label for="language">Domain Language</label>
                    <select name="language_id" id="language" class="form-control my-2">
                        <option value="" hidden selected>Domain Language</option>
                        @foreach ($languages as $language)
                            <option value="{{ $language->id }}" @selected(old('language_id' , $language) == $language->id)>{{ $language->name }}</option>
                        @endforeach
                    </select>
                </div>

                <input type="submit" value="Add Domain" class="btn btn-mine btn-mine mt-1">
                <input type="reset" value="تصفير" class="btn btn-outline-mine mt-1">
            </form>
        </div>
    </div>
@endsection
