@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <div class="row">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
            <form action="{{ route('words.save') }}" method="post" class="col-md-10 offset-md-1">
                <h4>confirm words </h4>
                @csrf
                <div class="row">   
                    <div class="col-11">
                        <p>{{ $phrase->content }}</p>
                    </div>

                    <div class="col-11">
                        <p>{{ $phrase->translation }}</textarea>
                    </div>
                </div>
                <h5 class="mt-5"> Words </h5>
                <table id="real" class="table">
                    <thead>
                        <tr>
                            <th class="d-none">word_id</th>
                            <th class=w-25>Content</th>
                            <th>word_type</th>
                            <th class="d-none">phraseWords_id</th>
                            <th class=w-25>translation</th>
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
                                    <select name="word_types[]" class="form-control my-2" required>
                                        <option value="" hidden> Word Type</option>
                                        @foreach ($word_types as $word_type)
                                            <option value="{{ $word_type->id }}" @selected(old("word_types[$i]", $words[$i]->word_type_id) == $word_type->id)>
                                                {{ $word_type->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="d-none"><input type="text" name="phraseWord_ids[]" value={{ $phraseWords[$i]->id }}> </td>

                                <td><input type="text" name="translations[]" class="form-control  d-inline-block w-50"
                                        value="{{ $phraseWords[$i]->translation }}">
                                    <input list="allTranslation{{ $i }}" type="text"
                                        class="form-control  d-inline-block w-50" onchange="takeValue(this)">
                                    <datalist id="allTranslation{{ $i }}">
                                        @foreach ($allTranslations[$i] as $allTranslation)
                                            <option>{{ $allTranslation->translation }}</option>
                                        @endforeach
                                    </datalist>
                                </td>
                                <td><input type="number" name="order[]" value="{{ $phraseWords[$i]->order }}" disabled
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
        }
    </script>
@endsection
