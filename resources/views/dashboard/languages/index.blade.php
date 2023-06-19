@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <h3>Languages Management</h3>
        <a onclick="history.back()" class="btn btn-mine my-2">&leftarrow;</a>
        <a href="{{ route('languages.create') }}" class="btn btn-mine my-2">Add Language</a>
        <table class="table table-striped table-hover text-center">
            <thead>
                <tr>
                    <td>id</td>
                    <td>name</td>
                    <td>key</td>
                    <td>actions</td>
                </tr>
            </thead>    
            <tbody>
                @foreach ($languages as $language)
                    <tr>
                        <td>{{ $language->id }}</td>
                        <td>{{ $language->name }}</td>
                        <td>{{ $language->key }}</td>
                        <td><a href="{{ route('languages.edit', ['language' => $language]) }}" class="btn btn-outline-primary btn-sm" title="edit"><i class="fas fa-edit"></i></a> |
                            <a href="{{ route('languages.delete', ['language' => $language]) }}" class="btn btn-outline-danger btn-sm" title="remove"><i class="fas fa-trash"></i></a> 
                        </td>
                    </tr>
                @endforeach
            </tbody>        
        </table>
    </div>
@endsection
