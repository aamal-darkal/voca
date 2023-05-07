@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <div class="row">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
            <table id="template" style="visibility: collapse;">
                <tr class="table-row">
                    <td>
                        <input type="text" name="locales[]" class="form-control" maxlength="255" required>
                    </td>
                    <td>
                        <input type="text" name="keys[]" class="form-control" minlength="5" maxlength="5" required>
                    </td>
                    <td>
                        <button type="button" class="pull-right btn btn-outline-mine" onclick="delete_row(this)">-</button>
                    </td>
                </tr>
            </table>
            <form action="{{ route('languages.store') }}" method="post" class="col-md-6 offset-md-3">
                <h4>Add Language </h4>
                @csrf
                <input type="text" name="name" value="{{ old('name') }}" placeholder="language name" required
                    maxlength="100" class="form-control my-2" maxlength="15">
                <div class="text-danger">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
                <input type="text" name="key" value="{{ old('key') }}" placeholder="language key" required
                minlength="2" maxlength="2" class="form-control my-2">
                <div class="text-danger">
                    @error('key')
                        {{ $message }}
                    @enderror
                </div>
               
                <h5 class="mt-5"> Dialects &nbsp;&nbsp;
                    <button type="button" id="add_row" class="btn btn-outline-mine" onclick="plus_row()">+</button>
                </h5>
                <table id="real" class="table">
                    <thead>
                        <tr>
                            <th>Locale</th>
                            <th>Key</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $locales = old('locales');
                            $keys = old('keys');
                        @endphp
                        @if ($locales)
                            @for ($i = 0; $i < count($locales); $i++)
                                <tr class="table-row">
                                    <td>
                                        <input type="text" name="locales[]" value="{{ $locales[$i] }}"
                                            class="form-control" required maxlength="15">
                                        <div class="text-danger">
                                            @error('locales')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" name="keys[]" value="{{ $keys[$i] }}"
                                            class="form-control" required minlength="5" maxlength="5">
                                    </td>
                                    <td>
                                        <button type="button" class="pull-right btn btn-outline-mine"
                                            onclick="delete_row(this)">-</button>
                                    </td>
                                </tr>
                            @endfor
                        @endif
                    </tbody>
                </table>
                <input type="submit" value="Add Language" class="btn btn-mine btn-mine mt-1">
                <input type="reset" value="تصفير" class="btn btn-outline-mine mt-1">
                <a href="{{ route('languages.index') }}" class="btn btn-outline-secondary my-2">تراجع</a>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function plus_row() {
            let template = document.getElementById("template").children[0].children[0];
            let newRow = template.cloneNode(true)
            document.querySelector("#real tbody").appendChild(newRow)
        }

        function delete_row(inp) {
            inp.parentNode.parentNode.remove();
        }

        
    </script>
@endsection
