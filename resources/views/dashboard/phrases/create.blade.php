@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <div class="row">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
            <h4>Add Language </h4>
            <form action="{{ route('languages.store') }}" method="post" class="col-md-6 offset-md-3">
                @csrf
                <input type="text" name="name" value="{{ old('name') }}" placeholder="language name" required
                    maxlength="100" class="form-control my-2" maxlength="255">
                <div class="text-danger">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
                <h5 class="mt-5"> Dialects &nbsp;&nbsp;
                    <button type="button" id="add_row" class="btn btn-outline-mine" onclick="plus_row()">+</button>
                </h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Locale</th>
                            <th>Key</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-row" style="visibility: collapse;">
                            <td>
                                <input type="text" name="locales[]" class="form-control" maxlength="255" required>                               
                            </td>
                            <td>
                                <input type="text" name="keys[]" class="form-control" minlength="5" maxlength="5" required>
                            </td>
                            <td>
                                <button type="button" class="pull-right btn btn-outline-mine"
                                    onclick="delete_row(this)">-</button>
                            </td>
                        </tr>
                        @php
                            $locales = old('locales');
                            $keys = old('keys');
                        @endphp
                        @if ($locales)
                            @for ($i = 0; $i < count($locales); $i++)
                            <tr class="table-row">
                                <td>
                                    <input type="text" name="locales[]" value="{{ $locales[$i] }}" class="form-control" required maxlength="255" >
                                    <div class="text-danger">
                                        @error('locales')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="keys[]" value="{{ $keys[$i] }}" class="form-control" required minlength="5" maxlength="5">
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
                <input type="button" value="Add Language" class="btn btn-mine btn-mine mt-1"
                    onclick="omit_template();submit()">
                <input type="reset" value="تصفير" class="btn btn-outline-mine mt-1">
                <a href="{{ route('languages.index') }}" class="btn btn-outline-secondary my-2">تراجع</a>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function delete_row(inp) {
            inp.parentNode.parentNode.remove();
        }

        function plus_row() {
            let template = document.querySelector(".table-row");
            let newRow = template.cloneNode(true)
            newRow.style.visibility = 'visible'
            document.querySelector('tbody').appendChild(newRow)
        }

        function omit_template() {
            let inputItems = document.querySelectorAll(".table-row:first-of-type input");
            for (let inputItem of inputItems)
                inputItem.name = ""
        }
    </script>
@endsection
