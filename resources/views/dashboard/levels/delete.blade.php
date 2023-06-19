@extends('layouts.dashboard')
@section('inside-content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-1">
                <h4><a href="{{ route('levels.index', ['domain' => $level->domain_id])}}" class="btn btn-mine my-2">&leftarrow;</a>
                    Delete Level </h4>
                @if ($participantCount > 0)
                    <h5 class="text-danger">You can't remove {{ $level->title }} because there are {{ $participantCount }}
                        participants related to it</h5>
                @elseif ($phraseCount > 0)
                    <h5 class="text-danger">You can't remove {{ $level->title }} because it has {{ $phraseCount }}
                        phrases</h5>
                @else
                    {{-- start form --}}
                    <form action="{{ route('levels.destroy', ['level' => $level]) }}" method="post">
                        @csrf
                        @method('delete')


                        <h5 class="text-danger"> Are you sure you want to remove {{ $level->title }}  </h5>

                        <label for="title">Level Title</label>
                        <input type="text" id="title" value="{{ $level->title }}" disabled
                            class="form-control my-2">
                        <label for="description">Level Description</label>
                        <input type="text" id="description" value="{{ $level->description }}" disabled
                            class="form-control my-2">
                      
                        <input type="button" value="Delete Level" class="btn btn-mine btn-mine mt-1" onclick="submit()">
                    </form>
                @endif
            </div>
            {{-- ################################### end - form ####################### --}}

        </div>
    </div>
@endsection
