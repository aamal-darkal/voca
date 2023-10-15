@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <div class="row">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
            <form action="{{ route('words.save') }}" method="post" class="col-md-10 offset-md-1" name="wordsForm">
                <h4><a href="{{ route('phrases.index') }}" class="btn btn-mine my-2">&leftarrow;</a>
                    specify phrase words </h4>
                @csrf
                <input type="text"  name="phrase_id" value="{{ $phrase->id }}"  class="form-control" hidden>

                <div class="row">
                    <div class="col-11">
                        <h5>Content</h5>
                        <input type="text" value="{{ $phrase->content }}" disabled class="form-control">
                    </div>

                    <div class="col-11 mt-2">
                        <h5>Translation</h5>
                        <input type="text"  name="translation" value="{{ $phrase->translation }}" class="form-control">
                    </div>
                </div>
                <h5 class="mt-3"> Words </h5>
                <table id="real" class="table">
                    <thead>
                        <tr class="">
                            <th class="d-none">word_id</th>
                            <th>Content</th>
                            <th>word_type</th>
                            <th class="d-none">phraseWords_id</th>
                            <th><label class="w-50">old-translation </label>
                                <label class=""> change-translation </label>
                            </th>
                            <th>Order</th>
                        </tr>
                    </thead>
                    <tbody>

                        @for ($i = 0; $i < count($words); $i++)
                            <tr>
                                <td class="d-none"><input type="text" name="word_ids[]" value={{ $words[$i]->id }}></td>
                                <td> <input type="text" value="{{ $words[$i]->content }}" disabled class="form-control">
                                </td>
                                <td class="control-group">
                                    <select name="wordTypes[]" class="form-control" >
                                        <option value="" hidden> Word Type</option>
                                        @foreach ($wordTypes as $wordType)
                                            <option value="{{ $wordType->id }}" @selected(old("wordTypes[$i]", $words[$i]->word_type_id) == $wordType->id)>
                                                {{ $wordType->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="d-none"><input type="text" name="phraseWord_ids[]"
                                        value={{ $phraseWords[$i]->id }}> </td>

                                <td>
                                    <input type="text" class="form-control d-inline-block w-49"
                                        value="{{ $phraseWords[$i]->translation }}" disabled>
                                    <input type="text" name="translations[]" value="{{ $phraseWords[$i]->translation }}"
                                        hidden>
                                    <input list="allTranslation{{ $i }}" type="text"
                                        class="form-control d-inline-block w-49" onchange="takeValue(this)">
                                    <datalist id="allTranslation{{ $i }}">
                                        @foreach ($allTranslations[$i] as $allTranslation)
                                            <option>{{ $allTranslation->translation }}</option>
                                        @endforeach
                                    </datalist>
                                </td>
                                <td><input type="text" name="order[]" value="{{ $phraseWords[$i]->order }}" disabled
                                        class="form-control w-100px"> </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
                <input type="submit" value="save words" class="btn btn-mine btn-mine mt-1">
                <input type="reset" value="تصفير" class="btn btn-outline-mine mt-1">
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function takeValue(inp) {
            inp.previousElementSibling.value = inp.value
            inp.previousElementSibling.previousElementSibling.value = inp.value
        }
    </script>
@endsection
