@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <h3>Domains Management</h3>
        <a onclick="history.back()" class="btn btn-mine my-2">&leftarrow;</a>
        <a href="{{ route('domains.create') }}" class="btn btn-mine my-2">Add Domain</a>
        <form action="{{ route('participants') }}" class="col-md-3">
            <label for="language">Language</label>
            <select name="language" id="language" onchange="submit()" class="form-control">
                <option value="*" @selected($selectedlang == '*')>All languages</option>
                @foreach($languages as $language)
                    <option value="{{ $language->id }}" @selected($language->id == $selectedlang)>{{ $language->name }}</option>
                @endforeach
            </select>
        </form>
        <table class="table table-striped table-hover text-center">
            <thead>
                <tr>
                    <td>id</td>
                    <td>title</td>
                    <td>description</td>
                    <td>level count</td>
                    <td>language</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($domains as $domain)
                    <tr>
                        <td>{{ $domain->id }}</td>
                        <td>{{ $domain->title }}</td>
                        <td>{{ $domain->description }}</td>
                        <td>{{ $domain->level_count }}</td>
                        <td>{{ $domain->language->name }}</td>
                        <td><a href="{{ route('domains.edit', ['domain' => $domain]) }}" class="btn btn-outline-primary btn-sm" title="edit"><i class="fas fa-edit"></i></a> |
                            <a href="{{ route('domains.show', ['domain' => $domain]) }}" class="btn btn-outline-success btn-sm" title="view"><i class="fas fa-eye"></i></a> |

                            <form action="{{ route('domains.destroy', ['domain' => $domain]) }}" method="post" onsubmit="return confirm('delete {{ $domain->name }}')" class="d-inline-block">
                                @csrf
                                @method('delete')
                                <button type="submit" title="delete" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                            |
                            <form action="{{ route('domains.destroy', ['domain' => $domain]) }}" method="post" onsubmit="return confirm('delete {{ $domain->name }} wih all its participants!!')" class="d-inline-block">
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
