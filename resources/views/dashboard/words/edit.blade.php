@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">
        <div class="row">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
            
            <form action="{{ route('words.update') }}" method="post" class="col-md-10 offset-md-1" name="phrase">
            <h4>Add Phrase </h4>                                    

                @csrf
                
                <div class="row">
                    <div class="col-11">
                        <p>{{ $phrase->content }}</p>
                    </div>
                   
                    <div class="col-11">
                        <p>{{ $phrase->translation}}</textarea>
                    </div>                                  
                </div>

                <h5 class="mt-5"> Words </h5>
                <table id="real" class="table">
                    <thead>
                        <tr>
                            <th>Content</th>
                            <th>Translation</th>
                            <th>Order</th>
                            <th>Word Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach ($words as $word)
                            <td>{{ $word['content'] }}</td>
                            <td>{{ $word['translation'] }}</td>
                            <td>{{ $word['order'] }}</td>
                        @endforeach                     
                    </tbody>
                </table>
                <input type="submit" value="Add phrases" class="btn btn-mine btn-mine mt-1">
                <input type="reset" value="تصفير" class="btn btn-outline-mine mt-1">
                <a href="{{ route('phrases.index') }}" class="btn btn-outline-secondary my-2">تراجع</a>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>                
    
    </script>
@endsection