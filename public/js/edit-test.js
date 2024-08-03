console.log('edit-test.js script is loaded from public');

function loadQuestions(questions) {
    var container = document.getElementById('edit-questions-container');
    container.innerHTML = ''; // Limpiar el contenedor
    questions.forEach((question, index) => {
        var questionBlock = document.createElement('div');
        questionBlock.classList.add('question-block', 'mb-4');
        questionBlock.innerHTML = `
            <div class="form-group">
                <label for="question-title">Questions</label>
                <input type="text" class="form-control question-title" placeholder="Enter a question title" value="${question.title}">
            </div>
            <div class="form-group">
                <label>Answer</label>
                <div class="answers-container">
                </div>
                <button type="button" class="btn btn-primary" onclick="addAnswer(this)">Add Answer</button>
            </div>

            <button type="button" class="btn btn-danger" onclick="removeQuestion(this)">Delete Question</button>

            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 100%"></div>
            </div>
        `;

        var answersContainer = questionBlock.querySelector('.answers-container');
        Object.keys(question).forEach(key => {
            if (key.startsWith('R')) {
                var answerIndex = key.substring(1);
                var isCorrect = question.Correct_response_index === key;
                var answerBlock = document.createElement('div');
                answerBlock.classList.add('answer-block');
                answerBlock.innerHTML = `
                    <input type="text" class="form-control answer-text" placeholder="Enter answer text" value="${question[key]}">
                    <p><input type="radio" name="correct_answer_${index}" value="${answerIndex}" ${isCorrect ? 'checked' : ''}>Correct</p>
                    <button type="button" class="btn btn-danger" onclick="removeAnswer(this)">Remove Answer</button>
                `;
                answersContainer.appendChild(answerBlock);
            }
        });

        container.appendChild(questionBlock);
    });
}

function addQuestion() {
    var container = document.getElementById('edit-questions-container');
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

function saveChanges() {
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
        var bankId = document.getElementById('bank-id').value;
        sendJsonToServer(jsonOutput, bankId);
    }
}

function sendJsonToServer(jsonData,bankId) {
    fetch('/admin/save-bank', { // URL del método de actualización
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ questions_json: jsonData,bank_id: bankId }) // Enviar el JSON como un objeto
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        if (data.success) {
            alert('Changes saved successfully!');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
