@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <h3>Domains Management</h3>
        <a onclick="history.back()" class="btn btn-mine my-2">&leftarrow;</a>
        <a href="{{ route('domains.create') }}" class="btn btn-mine my-2">Add Domain</a>
        <form action="{{ route('domains.index') }}" class="col-md-3">
            <label for="language">Language</label>
            <select name="language" id="language" onchange="submit()" class="form-control"> 
                <option value="*" @selected($selectedlang == '*')>All languages</option>
                @foreach ($languages as $language)
                    <option value="{{ $language->id }}" @selected($language->id == $selectedlang )>{{ $language->name }}</option>
                @endforeach
            </select>
        </form>
        <table class="table table-striped table-hover text-center">
            <thead>
                <tr>
                    <th>id</th>
                    <th>title</th>
                    <th>description</th>
                    <th>level count</th>
                    <th>order </th>
                    <th>language</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($domains as $domain)
                    <tr>
                        <td>{{ $domain->id }}</td>
                        <td>{{ $domain->title }}</td>
                        <td>{{ $domain->description }}</td>
                        <td>{{ $domain->level_count }}</td>
                        <td>{{ $domain->order }}</td>
                        <td>{{ $domain->language->name }}</td>
                        <td><a href="{{ route('domains.edit', ['domain' => $domain]) }}"
                                class="btn btn-outline-primary btn-sm" title="edit"><i class="fas fa-edit"></i></a> |
                            <form action="{{ route('domains.destroy', ['domain' => $domain]) }}" method="post"
                                onsubmit="return confirm('delete {{ $domain->titlep }}')" class="d-inline-block">
                                @csrf
                                @method('delete')
                                <button type="submit" title="delete" class="btn btn-outline-danger btn-sm"><i
                                        class="fas fa-trash"></i></button>
                            </form>
                            |
                            {{-- <form action="{{ route('domains.destroy', ['domain' => $domain]) }}" method="post"
                                onsubmit="return confirm('delete {{ $domain->name }} wih all its participants!!')"
                                class="d-inline-block">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="hard" id="" title="hard delete">

                                <button type="submit" title="hard delete" class="btn btn-outline-danger btn-sm"><i
                                        class="fas fa-book-dead"></i></button>
                            </form> --}}

                            <a href="{{ route('levels.index', ['domain' => $domain->id]) }}"
                                class="btn btn-outline-success">Levels</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
