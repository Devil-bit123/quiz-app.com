console.log('test.js script is loaded from respurces');

function addQuestion() {
    var container = document.getElementById('questions-container');
    var template = document.getElementById('question-template').innerHTML;
    container.insertAdjacentHTML('beforeend', template);
}

function removeQuestion(button) {
    button.closest('.question-block').remove();
}
