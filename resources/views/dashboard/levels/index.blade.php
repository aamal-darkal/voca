@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <h3> <span class="fst-italic">"{{ $domain }}"</span> Levels Management</h3>
        <a href="{{ route('domains.index') }}" class="btn btn-mine my-2">&leftarrow;</a>
        <a href="{{ route('levels.create') }}" class="btn btn-mine my-2">Add Level</a>
        
        <table class="table table-striped table-hover text-center">
            <thead>
                <tr>
                    <th>id</th>
                    <th>title</th>
                    <th>description</th>
                    <th>order</th>
                    <th>phrase count</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($levels as $level)
                    <tr>
                        <td>{{ $level->id }}</td>
                        <td>{{ $level->title }}</td>
                        <td>{{ $level->description }}</td>
                        <td>{{ $level->order }}</td>
                        <td>{{ $level->phrase_count }}</td>
                        <td><a href="{{ route('levels.edit', ['level' => $level]) }}"
                                class="btn btn-outline-primary btn-sm" title="edit"><i class="fas fa-edit"></i></a> |
                            <form action="{{ route('levels.destroy', ['level' => $level]) }}" method="post"
                                onsubmit="return confirm('delete {{ $level->name }}')" class="d-inline-block">
                                @csrf
                                @method('delete')
                                <button type="submit" title="delete" class="btn btn-outline-danger btn-sm"><i
                                        class="fas fa-trash"></i></button>
                            </form>
                            
                            {{-- |<form action="{{ route('levels.destroy', ['level' => $level]) }}" method="post"
                                onsubmit="return confirm('delete {{ $level->name }} wih all its participants!!')"
                                class="d-inline-block">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="hard" id="" title="hard delete">

                                <button type="submit" title="hard delete" class="btn btn-outline-danger btn-sm"><i
                                        class="fas fa-book-dead"></i></button>
                            </form>
                             --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
