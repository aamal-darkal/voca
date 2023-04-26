@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <h3>Participant </h3>
        <a onclick="history.back()" class="btn btn-mine my-2">&leftarrow;</a>
        <form action="{{ route('participants') }}" class="col-md-3">
            <label for="language">Language</label>
            <select name="language" id="language" onchange="submit()" class="form-control">
                <option value="*" @selected($selectedlang == '*')>All languages</option>
                @foreach($languages as $language)
                    <option value="{{ $language->id }}" @selected($language->id == $selectedlang)>{{ $language->name }}</option>
                @endforeach
            </select>
        </form>
        <table class="table table-striped table-hover text-center">
            <thead>
                <tr>
                    <td>image</td>
                    <td>name</td>
                    <td>email</td>
                    <td>learn_word_count</td>
                    <td>learn_phrase_count</td>
                    <td>language</td>
                    <td>is_admob</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($participants as $participant)
                    <tr>
                        <td>image</td>
                        <td>{{ $participant->name }}</td>
                        <td>{{ $participant->email }}</td>
                        <td>{{ $participant->learn_word_count }}</td>
                        <td>{{ $participant->learn_phrase_count }}</td>
                        <td>{{ $participant->dialect->language->name}} | {{ $participant->dialect->locale }}</td>
                        <td>{{ $participant->is_admob }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection