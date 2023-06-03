@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <div class="col-12">
            <h3><a onclick="history.back()" class="btn btn-mine my-2">&leftarrow;</a> Phrases Management</h3>
            <div class="col-10">
                <select id="languages" onchange="filter(this, 'domains')" class="form-control mt-2">
                    <option value="" selected hidden>--select language</option>
                    @foreach ($languages as $language)
                        <option value="{{ $language->id }}">{{ $language->name }}</option>
                    @endforeach
                </select>
                <select id="domains" onchange="filter(this, 'levels')" class="form-control mt-2">
                    <option value="" selected hidden>--select domain</option>
                    @foreach ($domains as $domain)
                        <option value="{{ $domain->id }}" data-fk="{{ $domain->language_id }}">{{ $domain->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <form action="{{ route('phrases.create') }}" class="row">
                <div class="col-10">
                    <select id="levels" name="level_id" onchange="filterTable(this, 'myTable' , 1)"
                        class="form-control mt-2" required>
                        <option value="" selected hidden>--select level</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}" data-fk="{{ $level->domain_id }}"> {{ $level->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-1">
                    <input type="submit" class="btn btn-mine my-2" value="Add Phrase">
                </div>
            </form>


            <table id="myTable" class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>content</th>
                        <th>translation</th>
                        <th>order</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($phrases as $phrase)
                        <tr>
                            <td>{{ $phrase->id }}</td>
                            <td style="display: none">{{ $phrase->level_id }}</td>
                            <td class="text-start">{{ $phrase->content }}</td>
                            <td class="text-start">{{ $phrase->translation }}</td>
                            <td class="text-center">{{ $phrase->order }}</td>

                            <td><a href="{{ route( 'phrases.edit', ['phrase' => $phrase]) }}"
                                    class="btn btn-outline-primary btn-sm" title="edit"><i class="fas fa-edit"></i></a> |                                
                                <form action="{{ route('phrases.destroy', ['phrase' => $phrase]) }}" method="post"
                                    onsubmit="return confirm('delete {{ $phrase->name }}')" class="d-inline-block">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" title="delete" class="btn btn-outline-danger btn-sm"><i
                                            class="fas fa-trash"></i></button>
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
            function filter(parentList, filteredList) {
                filteredList = document.getElementById(filteredList)
                filteredList.options[0].selected = true
                for (option of filteredList.options) {
                    if (option.getAttribute('data-fk') != parentList.value)
                        option.hidden = true
                    else
                        option.hidden = false
                }
            }

            function filterTable(mylist, mytable, column) {
                let myTable = document.getElementById(mytable)

                let trs = document.querySelectorAll(`#${mytable} tbody tr`)
                for (currTr of trs)
                    currTr.style.visibility = 'visible'

                for (currTr of trs) {
                    if (currTr.children[column].innerHTML != mylist.value)
                        currTr.style.visibility = 'collapse'
                }
            }
        </script>
    @endsection
