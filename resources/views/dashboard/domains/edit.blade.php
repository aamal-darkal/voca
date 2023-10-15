@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">

        <div class="row">
            {{-- display validation error --}}
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
            {{-- ========================== template  ======================================= --}}
            <table style="visibility: collapse;">
                <tr class="table-row" id="template">
                    <td>
                        <input type="text" name="titles[]" class="form-control min-w-100px" maxlength="100">
                    </td>
                    <td>
                        <input type="text" name="descriptions[]" class="form-control min-w-300px" maxlength="255" required>
                    </td>
                    <td>
                        <select name="languages[]" id="language" class="form-select my-2 min-w-150px" required>
                            <option value="" hidden> Lang</option>
                            @foreach ($languages as $language)
                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <button type="button" class="pull-right btn btn-outline-mine" onclick="delete_row(this)">-</button>
                    </td>
                </tr>
            </table>
            {{-- ========================== end template  ======================================= --}}
            <form action="{{ route('domains.update', ['domain' => $domain]) }}" method="post" class="col-md-10 offset-md-1">
                <h4><a href="{{ route('domains.index') }}" class="btn btn-mine my-2">&leftarrow;</a>
                    Edit Domain </h4>
                @csrf
                @method('put')

                {{-- ********************************************************************************** --}}
                <div class="col-4 control-group">
                    <label for="language">Domain Language</label>
                    <select name="language_id" id="language" class="form-select my-2" required>
                        <option value="" hidden selected>Domain Language</option>
                        @foreach ($languages as $language)
                            <option value="{{ $language->id }}" @selected(old('language_id', $domain->language_id) == $language->id)>{{ $language->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="control-group">
                    <label for="order">Order</label>
                    <input type="number" name="order" value="{{ old('order', $domain->order) }}" placeholder="Order"
                        min=1 class="form-control my-2 w-100px">
                    <div class="text-danger">
                        @error('order')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="real" class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>lang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="control-group">
                                    <input type="text" name="title" id="title"
                                        value="{{ old('title', $domain->title) }}" placeholder="Domain title"
                                        class="form-control my-2 min-w-100px" maxlength="100" required>
                                    <div class="text-danger">
                                        @error('title')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </td>

                                <td class="control-group">
                                    <input type="text" name="description"
                                        value="{{ old('description', $domain->title) }}" placeholder="Domain description"
                                        class="form-control my-2 min-w-300px " maxlength="255" required>
                                    <div class="text-danger">
                                        @error('description')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </td>

                                <td class="col-md-2 control-group min-w-150px">
                                    <input type="text" value="arabic" class="form-control my-2" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5 class="my-2"> Translations:
                                        <button type="button" id="add_row" class="btn btn-outline-mine my-2"
                                            onclick="plus_row()">+</button>
                                    </h5>
                                <td>
                            </tr>

                            {{-- has pre posted value (old) --}}
                            @php
                                $oldlanguages = old('languages');
                                $titles = old('titles');
                                $descriptions = old('descriptions');
                            @endphp
                            @if ($titles)
                                @for ($i = 0; $i < count($oldlanguages); $i++)
                                    <tr class="table-row">
                                        <td>
                                            <input type="text" name="titles[]" value="{{ $titles[$i] }}"
                                                class="form-control min-w-100px" maxlength="100" required>
                                        </td>
                                        <td>
                                            <input type="text" name="descriptions[]" value="{{ $descriptions[$i] }}"
                                                class="form-control min-w-300px" maxlength="255" required>
                                        </td>
                                        <td>
                                            <select name="languages[]" id="language" class="form-select my-2 min-w-150px" required>
                                                <option value="" hidden> Lang</option>
                                                @foreach ($languages as $language)
                                                    <option value="{{ $language->id }}" @selected($language->id == $oldlanguages[$i])>
                                                        {{ $language->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="pull-right btn btn-outline-mine"
                                                onclick="delete_row(this)">-</button>
                                        </td>
                                    </tr>
                                @endfor
                            @else
                                @foreach ($domain->languages as $lang)
                                    <tr class="table-row">
                                        <td>
                                            <input type="text" name="titles[]" value="{{ $lang->pivot->title }}"
                                                class="form-control min-w-100px" maxlength="100" required >
                                        </td>
                                        <td>
                                            <input type="text" name="descriptions[]"
                                                value="{{ $lang->pivot->description }}" class="form-control min-w-300px"
                                                maxlength="255" required >
                                        </td>
                                        <td>
                                            <select name="languages[]" id="language" class="form-select min-w-150px" required >
                                                <option value="" hidden> Lang</option>
                                                @foreach ($languages as $language)
                                                    <option value="{{ $language->id }}" @selected($language->id == $lang->id)>
                                                        {{ $language->name }}</option>
                                                @endforeach
                                            </select>
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
                </div>

                {{-- ****************************************************************************** --}}



                <input type="submit" value="save Domain" class="btn btn-mine btn-mine mt-1">
                <input type="reset" value="تصفير" class="btn btn-outline-mine mt-1">
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function plus_row() {
            let template = document.getElementById("template");
            console.log(template.innerHTML)
            let newRow = template.cloneNode(true)
            document.querySelector("#real tbody").appendChild(newRow)
        }

        function delete_row(inp) {
            inp.parentNode.parentNode.remove();
        }
    </script>
@endsection
