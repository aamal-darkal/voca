@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <h3>Phrases Management</h3>
        <a onclick="history.back()" class="btn btn-mine my-2">&leftarrow;</a>
        <a href="{{ route('phrases.create') }}" class="btn btn-mine my-2">Add Phrase</a>

        <select name="" id="">

        </select>



        <table id="myTable" class="table table-striped table-hover text-center">
            <thead>
                <tr>
                    <td>id</td>
                    <td>content</td>
                    <td>actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($phrases as $phrase)
                    <tr>
                        <td>{{ $phrase->id }}</td>
                        <td>{{ $phrase->content }}</td>
                        <td><a href="{{ route('phrases.edit', ['phrase' => $phrase]) }}"
                                class="btn btn-outline-primary btn-sm" title="edit"><i class="fas fa-edit"></i></a> |
                            <a href="{{ route('phrases.show', ['phrase' => $phrase]) }}"
                                class="btn btn-outline-success btn-sm" title="view"><i class="fas fa-eye"></i></a> |

                            <form action="{{ route('phrases.destroy', ['phrase' => $phrase]) }}" method="post"
                                onsubmit="return confirm('delete {{ $phrase->name }}')" class="d-inline-block">
                                @csrf
                                @method('delete')
                                <button type="submit" title="delete" class="btn btn-outline-danger btn-sm"><i
                                        class="fas fa-trash"></i></button>
                            </form>
                            |
                            <form action="{{ route('phrases.destroy', ['phrase' => $phrase]) }}" method="post"
                                onsubmit="return confirm('delete {{ $phrase->name }} wih all its participants!!')"
                                class="d-inline-block">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="hard" id="" title="hard delete">
                                <button type="submit" title="hard delete" class="btn btn-outline-danger btn-sm"><i
                                        class="fas fa-book-dead"></i></button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });

        $('#language-Id').on('change', function() {
            if (this.value == 1) {
                dataTable.search("Midlands & East of England").draw();
            } else {
                dataTable.search("North East, Yorkshire & Humberside").draw();
            }
        });
        $('#domain-id').on('change', function() {
            dataTable.search(this.value).draw();
        });
    </script>
@endsection
