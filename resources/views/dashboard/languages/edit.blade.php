@extends('layouts.dashboard')
@section('inside-content')
    <div class="container">
        <div class="row">
            {{-- ========================== template-dialect ======================================= --}}
            <table id="template-dialect" style="visibility: collapse;">
                <tr class="table-row">
                    <td>
                        <input type="hidden" name="dialectStates[]" value="new">
                        <input type="hidden" name="dialectIds[]" value="new">
                        <input type="text" name="locales[]" class="form-control" minlength="5" maxlength="5" required>
                    </td>
                    <td>
                        <input type="text" name="keys[]" class="form-control" maxlength="50" required>
                    </td>
                    <td>
                        <button type="button" class="pull-right btn btn-outline-mine"
                            onclick="delete_dialect(this)">-</button>
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
            </table>
            {{-- ========================== template-wordType ======================================= --}}
            <table id="template-wordType" style="visibility: collapse;">
                <tr class="table-row">
                    <td>
                        <input type="hidden" name="wordTypesStates[]" value="new">
                        <input type="hidden" name="wordTypesIds[]" value="new">
                        <input type="text" name="names[]" class="form-control" maxlength="50" required>
                    </td>
                    <td>
                        <button type="button" class="pull-right btn btn-outline-mine"
                            onclick="delete_wordType(this)">-</button>
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
            </table>
            {{-- ################################### start - form ####################### --}}
            <form action="{{ route('languages.update', ['language' => $language]) }}" method="post" class="col-md-6 offset-md-1">
                <h4><a href="{{ route('languages.index' ) }}" class="btn btn-mine my-2">&leftarrow;</a>
                Edit Language </h4>                
                @csrf
                @method('put')
                {{-- ****************************** language ****************************** --}}
                <label for="name">Language name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $language->name) }}"
                    placeholder="language name" required maxlength="50" class="form-control my-2">
                <div class="text-danger">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
                <label for="key">Language key</label>
                <input type="text" name="key" id="key" value="{{ old('key', $language->key) }}"
                    placeholder="language key" required minlength="2" maxlength="2" class="form-control my-2">
                <div class="text-danger">
                    @error('key')
                        {{ $message }}
                    @enderror
                </div>

                {{-- ****************************** Dialects ****************************** --}}
                <h5 class="mt-5"> Dialects &nbsp;&nbsp;
                    <button type="button" id="add_row" class="btn btn-outline-mine" onclick="plus_dialect()">+</button>
                </h5>
                <table class="table" id="real-dialects">
                    <thead>
                        <tr>
                            <th>Locale</th>
                            <th>Key</th>
                            <td>actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- has pre posted value (old) --}}
                        @php
                            $locales = old('locales');
                            $keys = old('keys');
                            $dialectStates = old('dialectStates');
                            $dialectIds = old('dialectIds');
                        @endphp
                        @if ($locales)
                            @for ($i = 0; $i < count($locales); $i++)
                                <tr class="table-row">
                                    <td>
                                        <input type="hidden" name="dialectStates[]" value="{{ $dialectStates[$i] }}">
                                        <input type="hidden" name="dialectIds[]" value="{{ $dialectIds[$i] }}">
                                        <input type="text" name="locales[]" value="{{ $locales[$i] }}"
                                            class="form-control" minlength="5" maxlength="5" required>
                                        <div class="text-danger">
                                            @error('locales')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" name="keys[]" value="{{ $keys[$i] }}"
                                            class="form-control" maxlength="50" required>
                                    </td>
                                    <td>
                                        <button type="button" class="pull-right btn btn-outline-mine"
                                            onclick="delete_dialect(this)">-</button>
                                    </td>
                                </tr>
                            @endfor
                        @else
                            {{-- has already saved value --}}
                            @php
                                $names = old('names');
                                $wordTypesStates = old('wordTypesStates');
                                $wordTypesIds = old('wordTypesIds');
                            @endphp
                            @foreach ($language->dialects as $dialect)
                                <tr class="table-row">
                                    <td>
                                        <input type="hidden" name="dialectStates[]" value="old">
                                        <input type="hidden" name="dialectIds[]" value="{{ $dialect->id }}">
                                        <input type="text" name="locales[]" value="{{ $dialect->locale }}"
                                            class="form-control" minlength="5" maxlength="5" required>

                                    </td>
                                    <td>
                                        <input type="text" name="keys[]" value="{{ $dialect->key }}"
                                            class="form-control" maxlength="50" required>
                                    </td>
                                    </td>
                                    <td>
                                        <button type="button" class="pull-right btn btn-outline-mine"
                                            onclick="delete_dialect(this)">-</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{-- ****************************** word types ****************************** --}}

                <h5 class="mt-5"> Word Types &nbsp;&nbsp;
                    <button type="button" id="add_row" class="btn btn-outline-mine"
                        onclick="plus_wordType()">+</button>
                </h5>
                <table class="table" id="real-wordTypes">
                    <thead>
                        <tr>
                            <th>names</th>
                            <td>actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- has pre posted value (old) --}}
                        @if ($names)
                            @for ($i = 0; $i < count($names); $i++)
                                <tr class="table-row">
                                    <td>
                                        <input type="hidden" name="wordTypesStates[]"
                                            value="{{ $wordTypesStates[$i] }}">
                                        <input type="hidden" name="wordTypesIds[]" value="{{ $wordTypesIds[$i] }}">
                                        <input type="text" name="names[]" value="{{ $names[$i] }}"
                                            class="form-control" maxlength="50" required>
                                        <div class="text-danger">
                                            @error('names')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="pull-right btn btn-outline-mine"
                                            onclick="delete_wordType(this)">-</button>
                                    </td>
                                </tr>
                            @endfor
                        @else
                            {{-- has already saved value --}}
                            @foreach ($language->wordTypes as $wordType)
                                <tr class="table-row">
                                    <td>
                                        <input type="hidden" name="wordTypesStates[]" value="old">
                                        <input type="hidden" name="wordTypesIds[]" value="{{ $wordType->id }}">
                                        <input type="text" name="names[]" value="{{ $wordType->name }}"
                                            class="form-control" maxlength="50" required>

                                    </td>
                                    <td>
                                        <button type="button" class="pull-right btn btn-outline-mine"
                                            onclick="delete_wordType(this)">-</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <input type="button" value="save Language" class="btn btn-mine btn-mine mt-1" onclick="submit()">
                <input type="reset" value="تصفير" class="btn btn-outline-mine mt-1">
            </form>
            {{-- ################################### end - form ####################### --}}

        </div>
    </div>
@endsection
@section('script')
    <script>
        function plus_dialect() {
            let template = document.getElementById("template-dialect").children[0].children[0];
            let newRow = template.cloneNode(true)
            document.querySelector("#real-dialects tbody").appendChild(newRow)
        }

        function delete_dialect(inp) {
            inp.parentNode.parentNode.style.visibility = 'collapse';
            inp.parentNode.parentNode.firstElementChild.firstElementChild.value = 'del';
        }

        function plus_wordType() {
            let template = document.getElementById("template-wordType").children[0].children[0];
            let newRow = template.cloneNode(true)
            document.querySelector("#real-wordTypes tbody").appendChild(newRow)
        }

        function delete_wordType(inp) {
            inp.parentNode.parentNode.style.visibility = 'collapse';
            inp.parentNode.parentNode.firstElementChild.firstElementChild.value = 'del';
        }
    </script>
@endsection
