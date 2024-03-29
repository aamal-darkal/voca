@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <div class="row">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
            <table id="template" style="visibility: hidden;">
                <tr class="table-row">
                    <td>
                        <input type="text" name="contents[]" class="form-control" readonly>
                    </td>
                    <td>
                        <input type="text" name="translations[]" class="form-control">
                    </td>
                    <td>
                        <select name="wordTypes[]" class="form-select">
                            <option value="" hidden selected>--word type</option>
                            @foreach ($wordTypes as $wordType)
                                <option value="{{ $wordType->id }}">{{ $wordType->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>
            <form action="{{ route('phrases.update' , ['phrase' => $phrase]) }}" method="post" class="col-md-10 offset-md-1" name="phrase">
                <h4><a href="{{ route('phrases.index' ) }}" class="btn btn-mine my-2">&leftarrow;</a>
                    Edit Phrase </h4>                  
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-11">
                        <textarea type="text" name="content" placeholder="phrase content" class="form-control mt-3" required class=""
                            onchange="generateWords(this.value)">{{ old('content' , $phrase->content) }}</textarea>
                    </div>
                    <div class="col-1">
                        <input type="hidden" id="word_count" name="word_count" value="{{ $phrase->word_count }}"> </output>
                    </div>

                    <div class="text-danger">
                        @error('content')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="col-11">
                        <textarea type="text" name="translation" placeholder="phrase translation" class="form-control mt-3">{{ old('translation' , $phrase->translation) }}</textarea>
                    </div>
                    <div class="text-danger">
                        @error('translation')
                            {{ $message }}
                        @enderror
                    </div>
                    {{-- @if (old('contents'))
                        <script>
                        </script>
                    @endif --}}
                </div>

                <h5 class="mt-5"> Words </h5>
                <table id="real" class="table">
                    <thead>
                        <tr>
                            <th>Content</th>
                            <th>Translation</th>
                            <th>Word Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
            
                        @for ($i=0 ; $i < count($words);$i++)
                            <tr class="table-row">
                                <td>
                                    <input type="text" name="contents[]" value="{{ $words[$i]->content }}" class="form-control" readonly>
                                </td>
                                <td>
                                    <input type="text" name="translations[]" value="{{ $words[$i]->pivot->translation }}" class="form-control">
                                </td>
                                <td>
                                    <select name="wordTypes[]" class="form-select">
                                        <option value="" hidden>--word type</option>
                                        @foreach ($wordTypes as $wordType)
                                            <option value="{{ $wordType->id }}" @selected($wordType->id == $words[$i]->word_type_id)>{{ $wordType->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
                <input type="submit" value="save phrases" class="btn btn-mine btn-mine mt-1">
                <input type="reset" value="تصفير" class="btn btn-outline-mine mt-1">
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function plus_row(word) {
            let template = document.getElementById("template").children[0].children[0];
            let newRow = template.cloneNode(true)
            newRow.children[0].children[0].value = word
            document.querySelector("#real tbody").appendChild(newRow)
        }

        function omit_words() {
            let wordRows = document.querySelectorAll("#real tbody tr");

            for (let wordRow of wordRows) {
                console.log(wordRow.innerHTML)
                wordRow.remove();
            }
        }

        function generateWords(phrase) {
            omit_words();
            let words = phrase.trim().split(" ")
            for (let word of words) {
                if (word.trim() != "")
                    plus_row(word)
            }
            document.getElementById("word_count").value = words.length
        }
    </script>
@endsection
