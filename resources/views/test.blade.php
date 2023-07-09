@extends('layouts.dashboard')
@section('inside-content')
    <div class="ui container center aligned">
        <h2 class="ui header green"> GeeksforGeeks </h2>

        <h3> Semantic-UI Form Multiple Select Content </h3>
    </div>  
 
    <div class="ui form">
        <div class="field">
            <label>
                Skills
            </label>

            <select multiple="" class="ui search selection dropdown">
                <option value="">
                    Select Multiple skills:
                </option>

                <option value="cpp">
                    C++
                </option>

                <option value="css">
                    CSS
                </option>

                <option value="dart">
                    Dart
                </option>

                <option value="firebase">
                    Firebase
                </option>

                <option value="flutter">
                    Flutter
                </option>

                <option value="java">
                    Java
                </option>

                <option value="Javascript">
                    Javascript
                </option>

                <option value="python">
                    Python
                </option>

                <option value="web-dev">
                    Web Development
                </option>
            </select>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('.ui.dropdown').dropdown();
    </script>
@endsection
