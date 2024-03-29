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
                        <input type="text" name="titles[]" class="form-control" maxlength="100">
                    </td>
                    <td>
                        <input type="text" name="descriptions[]" class="form-control" maxlength="255" required>
                    </td>
                    <td>
                        <select name="languages[]" id="language" class="form-select my-2" required>
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
            <div class="row">
                <form action="{{ route('levels.update', ['level' => $level]) }}" method="post" class="col-md-6 offset-md-1">
                <h4><a href="{{ route('levels.index', ['domain' => $level->domain]) }}" class="btn btn-mine my-2">&leftarrow;</a>
                    Edit Level </h4>
                    @csrf
                    @method('put')

                    <table id="real">
                        <thead>
                            <tr>
                                <th class="w-25">Title</th>
                                <th class="w-50">Description</th>
                                <th>lang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="control-group">
                                    <input type="text" name="title" id="title"
                                        value="{{ old('title', $level->title) }}" placeholder="Domain title"
                                        class="form-control my-2" maxlength="100" required>
                                    <div class="text-danger">
                                        @error('title')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </td>

                                <td class="control-group">
                                    <input type="text" name="description"
                                        value="{{ old('description', $level->description) }}"
                                        placeholder="Domain description" class="form-control my-2 " maxlength="255"
                                        required>
                                    <div class="text-danger">
                                        @error('description')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </td>

                                <td class="col-md-2 control-group">
                                    <input type="text" value="arabic" class="form-control my-2" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5 class="my-2"> Translations:
                                        <button type="button" id="add_row" class="btn btn-outline-mine"
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
                                                class="form-control" maxlength="100" required>
                                        </td>
                                        <td>
                                            <input type="text" name="descriptions[]" value="{{ $descriptions[$i] }}"
                                                class="form-control" maxlength="255" required>
                                        </td>
                                        <td>
                                            <select name="languages[]" id="language" class="form-select my-2" required>
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
                                @foreach ($level->languages as $lang)
                                    <tr class="table-row">
                                        <td>
                                            <input type="text" name="titles[]" value="{{ $lang->pivot->title }}"
                                                class="form-control" maxlength="100" required>
                                        </td>
                                        <td>
                                            <input type="text" name="descriptions[]"
                                                value="{{ $lang->pivot->description }}" class="form-control"
                                                maxlength="255" required>
                                        </td>
                                        <td>
                                            <select name="languages[]" id="language" class="form-select my-2" required>
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



                    <input type="submit" value="save Level" class="btn btn-mine btn-mine mt-1">
                    <input type="reset" value="تصفير" class="btn btn-outline-mine mt-1">
                </form>
            </div>
        </div>
    @endsection
