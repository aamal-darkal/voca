@extends('layouts.dashboard')
@section('inside-content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-1">
                <h4><a href="{{ route('domains.index') }}" class="btn btn-mine my-2">&leftarrow;</a>
                    Delete Domain </h4>
                @if ($participantCount > 0)
                    <h5 class="text-danger">You can't remove {{ $domain->title }} because it has {{ $participantCount }}
                        participants</h5>
                @elseif ($levelCount > 0)
                    <h5 class="text-danger">You can't remove {{ $domain->title }} because it has {{ $levelCount }}
                        levels</h5>
                @else
                    {{-- start form --}}
                    <form action="{{ route('domains.destroy', ['domain' => $domain]) }}" method="post">
                        @csrf
                        @method('delete')

                        {{-- ****************************** chaeck participants ****************************** --}}

                        <h5 class="text-danger"> Are you sure you want to remove {{ $domain->title }}  </h5>

                        {{-- ****************************** language ****************************** --}}
                        <label for="name">Language name</label>
                        <input type="text" id="name" value="{{ $domain->title }}" disabled
                            class="form-control my-2">
                        <label for="key">Language key</label>
                        <input type="text" id="key" value="{{ $domain->description }}" disabled
                            class="form-control my-2">
                      
                        <input type="button" value="delete Domain" class="btn btn-mine btn-mine mt-1" onclick="submit()">
                    </form>
                @endif
            </div>
            {{-- ################################### end - form ####################### --}}

        </div>
    </div>
@endsection
