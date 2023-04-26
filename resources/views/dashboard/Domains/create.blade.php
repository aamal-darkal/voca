@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <div class="row">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
            <form action="{{ route('domains.store') }}" method="post" class="col-md-6 offset-md-3">
                @csrf
                <h4>Add Domain </h4>

                <div class="control-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Domain title"
                        required maxlength="100" class="form-control my-2" maxlength="255">
                    <div class="text-danger">
                        @error('title')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="control-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" value="{{ old('description') }}"
                        placeholder="Domain description" required maxlength="100" class="form-control my-2" maxlength="255">
                    <div class="text-danger">
                        @error('description')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="control-group">
                    <label for="language">Level count</label>
                    <input type="number" name="level_count" value="{{ old('level_count') }}" placeholder="Level Count"
                        required maxlength="100" class="form-control my-2" >
                    <div class="text-danger">
                        @error('level_count')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="control-group">
                    <label for="language">Domain Language</label>
                    <select name="language_id" id="language" class="form-control my-2">
                        <option value="" hidden selected>Domain Language</option>
                        @foreach ($languages as $language)
                            <option value="{{ $language->id }}" @selected(old('language_id') == $language->id)>{{ $language->name }}</option>
                        @endforeach
                    </select>
                </div>
               
                <input type="submit" value="Add Domain" class="btn btn-mine btn-mine mt-1">
                <input type="reset" value="تصفير" class="btn btn-outline-mine mt-1">
                <a href="{{ route('domains.index') }}" class="btn btn-outline-secondary my-2">تراجع</a>
            </form>
        </div>
    </div>
@endsection
