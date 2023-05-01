@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <h3>Edit language </h3>
            <form action="{{ route('languages.update', ['language' => $language]) }}" method="post"
                class="col-md-6 offset-md-3">
                @csrf
                @method('put')
                <input type="text" name="name" value="{{ old('name', $language->name) }}" placeholder="language name"
                    required maxlength="50" class="form-control my-2">
                <div class="text-danger">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
                <h5 class="mt-5"> Dialects &nbsp;&nbsp;
                    <button type="button" id="add_row" class="btn btn-outline-mine" onclick="plus_row()">+</button>
                </h5>
                <table class="table" id="dialects_table">
                    <thead>
                        <tr>
                            <th>Locale</th>
                            <th>Key</th>
                            <td>actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-row" style="visibility: collapse;">
                            <td>
                                <input type="hidden" name="states[]" value="new">
                                <input type="hidden" name="ids[]" value="new">
                                <input type="text" name="locales[]" class="form-control" required maxlength="255">
                            </td>
                            <td>
                                <input type="text" name="keys[]" class="form-control" required minlength="5"
                                    maxlength="5">
                            </td>
                            <td>
                                <button type="button" class="pull-right btn btn-outline-mine"
                                    onclick="delete_row(this)">-</button>
                            </td>
                        </tr>
                        <div class="text-danger">
                            @error('locales.*')
                                {{ $message }}
                            @enderror
                            @error('keys.*')
                                {{ $message }}
                            @enderror
                        </div>
                        @php
                            $locales = old('locales');
                            $keys = old('keys');
                            $states = old('states');
                            $ids = old('ids');
                        @endphp
                        @if ($locales)
                            @for ($i = 0; $i < count($locales); $i++)
                                <tr class="table-row">
                                    <td>
                                        <input type="hidden" name="states[]" value="{{ $states[$i] }}">
                                        <input type="hidden" name="ids[]" value="{{ $ids[$i] }}">
                                        <input type="text" name="locales[]" value="{{ $locales[$i] }}"
                                            class="form-control" maxlength="255">
                                        <div class="text-danger">
                                            @error('locales')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" name="keys[]" value="{{ $keys[$i] }}"
                                            class="form-control" required>
                                    </td>
                                    <td>
                                        <button type="button" class="pull-right btn btn-outline-mine"
                                            onclick="delete_row(this)">-</button>
                                    </td>
                                </tr>
                            @endfor
                        @else
                            @foreach ($language->dialects as $dialect)
                                <tr class="table-row">
                                    <td>
                                        <input type="hidden" name="states[]" value="old">
                                        <input type="hidden" name="ids[]" value="{{ $dialect->id }}">
                                        <input type="text" name="locales[]" value="{{ $dialect->locale }}" 
                                            class="form-control" required maxlength="255">

                                    </td>
                                    <td>
                                        <input type="text" name="keys[]" value="{{ $dialect->key }}"
                                            class="form-control" required minlength="5" maxlength="5">
                                    </td>
                                    </td>
                                    <td>
                                        <button type="button" class="pull-right btn btn-outline-mine"
                                            onclick="delete_row(this)">-</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <input type="button" value="save Language" class="btn btn-mine btn-mine mt-1"
                    onclick="omitTemplate();submit()">
                <input type="reset" value="تصفير" class="btn btn-outline-mine mt-1">
                <a href="{{ route('languages.index') }}" class="btn btn-outline-secondary my-2">تراجع</a>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function delete_row(inp) {
            inp.parentNode.parentNode.style.visibility = 'collapse';
            inp.parentNode.parentNode.firstElementChild.firstElementChild.value = 'del';
        }

        function plus_row() {
            let template = document.querySelector(".table-row");
            let newRow = template.cloneNode(true)
            newRow.style.visibility = 'visible'
            document.querySelector('tbody').appendChild(newRow)
        }

        function omitTemplate() {
            let inputItems = document.querySelectorAll(".table-row:first-of-type input");
            for (let inputItem of inputItems)
                inputItem.name = ""
        }
    </script>
@endsection
