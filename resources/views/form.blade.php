@extends('layouts.app')

@section('script')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div style="height:35px;"></div>

    <form class="survey-form header">
        <div class="title">
            <i class="far fa-list-alt"></i>
            <span class="ps-2">{{ $results['data']['survey']['title'] }}</span>
        </div>
    </form>

    <div id="inputFields" class="step-content current" survey-id={{ $results['data']['survey']['id'] }}>
        <form class="survey-form mt-4" id="survey-form">
            @csrf
            <input type="hidden" name="_accessToken" value="{{ session('access_token') }}">

            <div id="form-inputs">
                @foreach ($results['data']['survey_questions'] as $key => $question)
                    @if (in_array($question['type'], ['text', 'date', 'number']))
                        <div class="input-fields">
                            <div class="space-between">
                                <label for="email">{{ $question['question'] }}</label>
                            </div>
                            <div class="field">
                                <input id="{{ $question['id'] }}" type="{{ $question['type'] }}"
                                    name="input{{ $question['id'] }}" placeholder="Please enter value here" required>

                                <div id="answers.{{ $key }}.answer" class="form-error"></div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="fields buttons">
                <a class="btn" onclick="submit()">
                    <i class="fas fa-paper-plane"></i>
                    <span>&nbsp;Submit</span>
                </a>
            </div>
        </form>
    </div>
    <div style="height:15px;"></div>

    <script>
        function removeErrors() {
            var elements = document.getElementsByClassName('form-error');
            for (var i = 0; i < elements.length; i++) {
                elements[i].innerHTML = '';
            }
        }

        function submit() {
            removeErrors();
            let answers = [];
            const inputFields = document.getElementById("inputFields");
            const inputs = inputFields.getElementsByClassName("input-fields");

            for (let i = 0; i < inputs.length; i++) {
                var answer = inputs[i].getElementsByTagName("input")[0];

                answers.push({
                    'survey_question_id': answer.getAttribute('id'),
                    'answer': answer.value,
                });
            }

            var params = {
                survey_id: inputFields.getAttribute('survey-id'),
                answers: answers,
            };

            var xhr = new XMLHttpRequest();
            var url = '/api/v1/survey/answer';
            var jsonData = JSON.stringify(params);

            xhr.open('POST', url);
            xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementById('survey-form').querySelector(
                'input[name="_token"]').value);
            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
            xhr.setRequestHeader('Authorization', 'Bearer ' + document.getElementById('survey-form').querySelector(
                'input[name="_accessToken"]').value);

            xhr.onload = function() {
                let response = JSON.parse(xhr.responseText);

                if (xhr.status === 200) {
                    alert(response.message);
                    location.reload();
                } else {
                    if (response.errors.details != null) {
                        let details = response.errors.details;
                        let errors = Object.keys(details);

                        for (let i = 0; i < errors.length; i++) {
                            const element = details[i];
                            document.getElementById(errors[i]).innerHTML = details[errors[i]];
                        }
                    }
                    var myDiv = document.getElementById('myDiv');
                }
            };
            xhr.send(jsonData);
        }
    </script>
@endsection
