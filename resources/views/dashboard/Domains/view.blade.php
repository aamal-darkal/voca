@extends('layouts.dashboard')
@section('inside-content')
    <div class="container">
        <h3> {{ $domain->title }} - Levels</h3>
        <a onclick="history.back()" class="btn btn-mine my-2">&leftarrow;</a>
        <table class="table table-striped table-hover text-center">
            <thead>
                <tr>
                    <td>id</td>
                    <td>locale</td>
                    <td>key</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($domain->dialects as $dialect)
                    <tr>
                        <td>{{ $dialect->id }}</td>
                        <td>{{ $dialect->locale }}</td>
                        <td>{{ $dialect->key }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
