@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <div class="row">

            {{-- error display --}}
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach

            {{-- ========================== template-dialect ======================================= --}}
            <table id="template-dialect" style="visibility: collapse;">
                <tr class="table-row">
                    <td>
                        <input type="text" name="locales[]" class="form-control" minlength="5" maxlength="5" required>
                    </td>
                    <td>
                        <input type="text" name="keys[]" class="form-control"  maxlength="50" required>
                    </td>
                    <td>
                        <button type="button" class="pull-right btn btn-outline-mine"
                            onclick="delete_dialect(this)">-</button>
                    </td>
                </tr>
            </table>
            {{-- ========================== template-wordType ======================================= --}}
            <table id="template-wordType" style="visibility: collapse;">
                <tr class="table-row">
                    <td>
                        <input type="text" name="names[]" class="form-control" maxlength="50" required>
                    </td>
                    <td>
                        <button type="button" class="pull-right btn btn-outline-mine"
                            onclick="delete_wordType(this)">-</button>
                    </td>
                </tr>
            </table>

            {{-- ################################### start - form ####################### --}}
            <form action="{{ route('languages.store') }}" method="post" class="col-md-6 offset-md-1">
                <h4><a href="{{ route('languages.index' ) }}" class="btn btn-mine my-2">&leftarrow;</a>
                Add Language </h4>
                @csrf
                {{-- ****************************** language ******************************--}}                
                <input type="text" name="name" value="{{ old('name') }}" placeholder="language name" required
                    maxlength="50" class="form-control my-2" maxlength="50">
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

                {{-- ***************************** Dialects ***************************** --}}
                <h5 class="mt-5"> Dialects &nbsp;&nbsp;
                    <button type="button" id="add_row" class="btn btn-outline-mine" onclick="plus_dialect()">+</button>
                </h5>
                <table id="real-dialects" class="table">
                    <thead>
                        <tr>
                            <th>Locale</th>
                            <th>Key</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- has pre posted value (old) --}}
                        @php
                            $locales = old('locales');
                            $keys = old('keys');
                        @endphp                        
                        @if ($locales)
                            @for ($i = 0; $i < count($locales); $i++)
                                <tr class="table-row">
                                    <td>
                                        <input type="text" name="locales[]" value="{{ $locales[$i] }}"
                                            class="form-control" minlength="5" maxlength="5" required>                                        
                                    </td>
                                    <td>
                                        <input type="text" name="keys[]" value="{{ $keys[$i] }}"
                                            class="form-control"  maxlength="50" required>
                                    </td>
                                    <td>
                                        <button type="button" class="pull-right btn btn-outline-mine"
                                            onclick="delete_dialect(this)">-</button>
                                    </td>
                                </tr>
                            @endfor
                        @endif
                    </tbody>
                </table>

                {{-- ***************************** wordtype***************************** --}}
                <h5 class="mt-5"> Word Types &nbsp;&nbsp;
                    <button type="button" id="add_row" class="btn btn-outline-mine" onclick="plus_wordType()">+</button>
                </h5>
                <table id="real-wordType" class="table">
                    <thead>
                        <tr>
                            <th>name</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- has pre posted value (old) --}}
                        @php
                            $names = old('names');
                        @endphp
                        @if ($names)
                            @for ($i = 0; $i < count($names); $i++)
                                <tr class="table-row">                                    
                                    <td>
                                        <input type="text" name="names[]" value="{{ $keys[$i] }}"
                                            class="form-control" required maxlength="50">
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
                        @endif
                    </tbody>
                </table>
                <input type="submit" value="Add Language" class="btn btn-mine btn-mine mt-1">
                <input type="reset" value="تصفير" class="btn btn-outline-mine mt-1">
            </form>
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
            inp.parentNode.parentNode.remove();
        }

        function plus_wordType() {
            let template = document.getElementById("template-wordType").children[0].children[0];
            let newRow = template.cloneNode(true)
            document.querySelector("#real-wordType tbody").appendChild(newRow)
        }

        function delete_wordType(inp) {
            inp.parentNode.parentNode.remove();
        }
    </script>
@endsection
