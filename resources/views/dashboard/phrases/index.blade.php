@extends('layouts.dashboard')
@section('inside-content')
    <div class="container-fluid">   
        <div id="test"></div>     
        <h3><a onclick="history.back()" class="btn btn-mine">&leftarrow;</a> Phrases Management</h3>
        <select id="languages" onchange="getDomains(this.value)" class="form-select mt-2">
            <option value="all"> All Languages</option>
            @foreach ($languages as $language)
                <option value="{{ $language->id }}">{{ $language->name }}</option>
            @endforeach
        </select>
        <select id="domains" onchange="getLevels(this.value)" class="form-select mt-2">
            {{-- domains options --}}
        </select>
        <form action="{{ route('phrases.create') }}">
            <select id="levels" name="level_id" onchange="getPhrases(this.value)" class="form-select mt-2" required>
                {{-- level options --}}
            </select>
            <div class="text-center">
                <input id="addPhrase" disabled type="submit" class="btn btn-mine my-2 w-50" value="Add Phrase">
                <span class="fst-italic">Choose level before adding phrase</span>

            </div> 

            {{-- {{ $phrases->links('pagination::bootstrap-5') }} --}}

            <div class="table-responsive">
                <table id="myTable" class="table table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th>
                                <div class="min-w-300px text-start">content</div>
                            </th>
                            <th>
                                <div class="min-w-300px text-start">translation</div>
                            </th>
                            <th>word_count</th>
                            <th>order</th>
                            <th>actions</th>
                        </tr>
                    </thead>
                    <tbody id="phrasesRows">
                        {{-- phrasesRows --}}
                    </tbody>
                </table>
            </div>
    </div>
@endsection
@section('script')
    <script>
        getDomains('all')

        async function getDomains(language_id) {
            //fetch data async
            let response = await fetch('domains/getDomains/' + language_id);
            let datas = await response.json();
            let domainSelect = document.getElementById('domains')
            domainSelect.innerHTML = ""
            domainSelect.add(new Option(' All Domains', 'all'))
            for (let data of datas) {
                let op = document.createElement('option')
                op.value = data['id']
                op.text = data['title']
                domainSelect.options.add(op)
            }
            getLevels('all')
        }

        async function getLevels(domain) {
            let language = document.getElementById('languages').value
            let response = await fetch(`levels/gelLevels/${domain}/${language}`);
            let datas = await response.json();
            let levelSelect = document.getElementById('levels')
            levelSelect.innerHTML = ""
            levelSelect.add(new Option('All Levels', 'all'))

            for (let data of datas) {
                let op = document.createElement('option')
                op.value = data['id']
                op.text = data['title']
                levelSelect.options.add(op)
            }

            getPhrases('all')
        }
        async function getPhrases(level) {
            let language = document.getElementById('languages').value
            let domain = document.getElementById('domains').value
            let response = await fetch(`phrases/getPhrases/${level}/${domain}/${language}`);

            let datas = await response.json();
            datas = datas.data
            let phraseRows = document.getElementById('phrasesRows')
            phraseRows.innerHTML = ''
            rows = ''
            for (let data of datas) {

                rows += `<tr>
                            <td class='text-start'>${data['content']}</td>
                            <td class='text-start'>${data['translation']}</td>
                            <td>${data['word_count']}</td>
                            <td>${data['order']}</td>   
                            <td class="text-center nowrap">
                                        <a href="phrases/${data['id']}/edit"
                                            class="btn btn-outline-primary btn-sm" title="edit"><i
                                                class="fas fa-edit"></i></a> | 
                                        <a href="phrases/delete/${data['id']}"
                                        class="btn btn-outline-danger btn-sm" title="remove"><i
                                                class="fas fa-trash"></i></a>                                    
                            </td>               
                        <tr>`;
            }
            phraseRows.innerHTML = rows

            if(level != 'all') 
                document.getElementById('addPhrase').disabled = false
            else
                document.getElementById('addPhrase').disabled = true

        }
    </script>
@endsection
