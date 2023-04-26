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
                    <td>actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($languages as $language)
                    <tr>
                        <td>{{ $language->id }}</td>
                        <td>{{ $language->name }}</td>
                        <td><a href="{{ route('languages.edit', ['language' => $language]) }}" class="btn btn-outline-primary btn-sm" title="edit"><i class="fas fa-edit"></i></a> |
                            <a href="{{ route('languages.show', ['language' => $language]) }}" class="btn btn-outline-success btn-sm" title="view"><i class="fas fa-eye"></i></a> |

                            <form action="{{ route('languages.destroy', ['language' => $language]) }}" method="post" onsubmit="return confirm('delete {{ $language->name }}')" class="d-inline-block">
                                @csrf
                                @method('delete')
                                <button type="submit" title="delete" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                            |
                            <form action="{{ route('languages.destroy', ['language' => $language]) }}" method="post" onsubmit="return confirm('delete {{ $language->name }} wih all its participants!!')" class="d-inline-block">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="hard" id="" title="hard delete">
                            <button type="submit" title="hard delete" class="btn btn-outline-danger btn-sm"><i class="fas fa-book-dead"></i></button>                            
                        </form> 

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
