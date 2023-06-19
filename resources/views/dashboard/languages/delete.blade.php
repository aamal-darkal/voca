@extends('layouts.dashboard')
@section('inside-content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-1">
                <h4><a href="{{ route('languages.index') }}" class="btn btn-mine my-2">&leftarrow;</a>
                    Delete Language </h4>
                @if ($participantCount > 0)
                    <h5 class="text-danger">You can't remove {{ $language->name }} because it has {{ $participantCount }}
                        participants</h5>
                
                @elseif ($domainCount > 0)
                    <h5 class="text-danger">You can't remove {{ $language->name }} because it has {{ $domainCount }}
                        domains</h5>
                @else
                    {{-- start form --}}
                    <form action="{{ route('languages.destroy', ['language' => $language]) }}" method="post">                        
                        @csrf
                        @method('delete')

                        {{-- ****************************** chaeck participants ****************************** --}}

                        <h5 class="text-danger"> Are you sure you want to remove {{ $language->name }} with its Dialects and
                            word types </h5>

                        {{-- ****************************** language ****************************** --}}
                        <label for="name">Language name</label>
                        <input type="text" id="name" value="{{ $language->name }}" disabled
                            class="form-control my-2">
                        <label for="key">Language key</label>
                        <input type="text" id="key" value="{{ $language->key }}" disabled
                            class="form-control my-2">

                        {{-- ****************************** Dialects ****************************** --}}
                        <h5 class="mt-5"> Dialects </h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Locale</th>
                                    <th>Key</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($language->dialects as $dialect)
                                    <tr class="table-row">
                                        <td> <input disabled value="{{ $dialect->id }}"> </td>
                                        <td> <input disabled value="{{ $dialect->locale }}"> </td>
                                        <td> <input disabled value="{{ $dialect->key }}"> </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- ****************************** word types ****************************** --}}

                        <h5 class="mt-5"> Word Types &nbsp;&nbsp; </h5>
                        <table class="table" id="real-wordTypes">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($language->wordTypes as $wordType)
                                    <tr class="table-row">
                                        <td> <input disabled value="{{ $wordType->id }}"> </td>
                                        <td> <input disabled value="{{ $wordType->name }}"> </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <input type="button" value="delete Language" class="btn btn-mine btn-mine mt-1" onclick="submit()">
                    </form>
                @endif
            </div>
            {{-- ################################### end - form ####################### --}}

        </div>
    </div>
@endsection
