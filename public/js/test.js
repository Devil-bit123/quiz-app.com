console.log('test.js script is loaded from public');

function addQuestion() {
    var container = document.getElementById('questions-container');
    var template = document.getElementById('question-template').innerHTML;
    container.insertAdjacentHTML('beforeend', template);
}

function addAnswer(button) {
    var container = button.previousElementSibling;
    var answerBlock = document.createElement('div');
    answerBlock.classList.add('answer-block');
    var answerCount = container.querySelectorAll('.answer-block').length + 1;
    var questionBlock = button.closest('.question-block');
    var questionId = questionBlock.querySelector('.question-title').value || 'question';

    answerBlock.innerHTML = `
        <input type="text" class="form-control answer-text" placeholder="Enter answer text">
        <p><input type="radio" name="correct_answer_${questionId}" value="${answerCount}">Correct</p>
        <button type="button" class="btn btn-danger" onclick="removeAnswer(this)">Remove Answer</button>
    `;
    container.appendChild(answerBlock);
}

function removeAnswer(button) {
    button.closest('.answer-block').remove();
}

function removeQuestion(button) {
    button.closest('.question-block').remove();
}

function generateJSON() {
    var questions = [];
    var questionBlocks = document.querySelectorAll('.question-block');
    var allQuestionsValid = true;

    questionBlocks.forEach((block, index) => {
        var title = block.querySelector('.question-title').value;
        var answers = {};
        var correctAnswerIndex = null;
        var answerBlocks = block.querySelectorAll('.answer-block');

        answerBlocks.forEach((answerBlock, answerIndex) => {
            var text = answerBlock.querySelector('.answer-text').value;
            var isCorrect = answerBlock.querySelector('input[type="radio"]').checked;
            answers[`R${answerIndex + 1}`] = text;
            if (isCorrect) {
                correctAnswerIndex = `R${answerIndex + 1}`;
            }
        });

        if (correctAnswerIndex === null) {
            allQuestionsValid = false;
        }

        questions.push({
            title: title,
            ...answers,
            Correct_response_text: correctAnswerIndex ? answers[correctAnswerIndex] : '',
            Correct_response_index: correctAnswerIndex
        });
    });

    if (!allQuestionsValid) {
        document.getElementById('error-message').textContent = 'Error: All questions must have a correct answer marked.';
    } else {
        document.getElementById('error-message').textContent = '';
        var jsonOutput = JSON.stringify(questions, null, 2);
        document.getElementById('json-output').textContent = jsonOutput;

        sendJsonToParent(jsonOutput);
    }
}

function sendJsonToParent(jsonData) {
    fetch('/admin/receive-json', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: jsonData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        if (data.success) {
            window.parent.updateTestJsonField(JSON.stringify(data.data));
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
