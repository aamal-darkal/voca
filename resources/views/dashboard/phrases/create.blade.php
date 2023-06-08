@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <div class="row">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach

            <form action="{{ route('phrases.store') }}" method="post" class="col-md-10 offset-md-1" name="phrase">
                <h4><a href="{{ route('phrases.index') }}" class="btn btn-mine my-2">&leftarrow;</a>
                    Add Phrase </h4>
                @csrf
                <input type="hidden" name="level_id" value="{{ $level_id }}">

                <div class="row">
                    <div class="col-11">
                        <textarea type="text" name="content" placeholder="phrase content" class="form-control mt-3" required>{{ old('content') }}</textarea>
                    </div>
                    <div class="text-danger">
                        @error('content')
                            {{ $message }}
                        @enderror
                    </div>

                    <div class="col-11">
                        <textarea type="text" name="translation" placeholder="phrase translation" class="form-control mt-3">{{ old('translation') }}</textarea>
                    </div>
                    <div class="text-danger">
                        @error('translation')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <input type="submit" value="Add phrases" class="btn btn-mine btn-mine mt-1">
                <input type="reset" value="تصفير" class="btn btn-outline-mine mt-1">
                <a href="{{ route('phrases.index') }}" class="btn btn-outline-secondary my-2">تراجع</a>
            </form>
        </div>
    </div>
@endsection
