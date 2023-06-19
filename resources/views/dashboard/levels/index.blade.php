@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <h3> {{ $domain->title }} - Levels Management</h3>
        <a href="{{ route('domains.index') }}" class="btn btn-mine my-2">&leftarrow;</a>
        <a href="{{ route('levels.create', ['domain' => $domain]) }}" class="btn btn-mine my-2">Add Level</a>

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
                        <td>
                            <a href="{{ route('levels.edit', ['level' => $level, 'domain' => $domain->id]) }}"
                                class="btn btn-outline-primary btn-sm" title="edit"><i class="fas fa-edit"></i></a> |
                            <a href="{{ route('levels.delete', ['level' => $level, 'domain' => $domain->id]) }}"
                                class="btn btn-outline-danger btn-sm" title="remove"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
