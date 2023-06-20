@extends('layouts.dashboard')
@section('inside-content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 offset-md-1">
                <h4><a href="{{ route('phrases.index') }}" class="btn btn-mine my-2">&leftarrow;</a>
                    Delete Phrase </h4>
                @if ($participantCount > 0)
                    <h5 class="text-danger">You can't remove this phrase: <h5>
                        <h5> {{ $phrase->content }} <h5>
                            <h5 class="text-danger">   because it has {{ $participantCount }} participants</h5>               
                @else
                    {{-- start form --}}
                    <form action="{{ route('phrases.destroy', ['phrase' => $phrase]) }}" method="post">
                        @csrf
                        @method('delete')

                        {{-- ****************************** check participants ****************************** --}}

                        <h5 class="text-danger"> Are you sure you want to remove {{ $phrase->content }}  </h5>
                        
                        <input type="button" value="Delete Phrase" class="btn btn-mine btn-mine mt-1" onclick="submit()">
                    </form>
                @endif
            </div>
            {{-- ################################### end - form ####################### --}}

        </div>
    </div>
@endsection
