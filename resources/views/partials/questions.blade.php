@php
    use App\Constants\English;
@endphp

<div id="questions-container" data-user="{{ json_encode($user) }}" data-test="{{ json_encode($test) }}">
    @foreach ($random_questions as $index => $question)
        <p id="question-index-counter"></p>
        <div class="question" data-index="{{ $index }}" data-correct-response-index="{{ $question['Correct_response_index'] }}"
        data-correct-response-text="{{ $question['Correct_response_text'] }}" style="display: none;">
            <p>{{ $question['title'] }}</p>
            @foreach (['R1', 'R2', 'R3', 'R4', 'R5'] as $answerKey)
                @if (isset($question[$answerKey]))
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question_{{ $index }}" value="{{ $answerKey }}">
                        <label class="form-check-label">{{ $question[$answerKey] }}</label>
                    </div>
                @endif
            @endforeach
        </div>
    @endforeach
</div>

<div id="navigation-buttons">
    <button id="prev-button" disabled>Previous</button>
    <button id="next-button">Next</button>
</div>

<div id="timer" style="font-size: 1.5em; font-weight: bold; color: red;">
    <!-- Aquí se mostrará el temporizador -->
</div>

<!-- Include the external JavaScript file -->
<script src="{{ asset('js/questions.js') }}"></script>
