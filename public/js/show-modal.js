$(document).ready(function() {
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var questionsJson = button.data('questions');

        console.log("JSON:", questionsJson);
        console.log("Type of JSON:", typeof questionsJson);

        try {
            // Directly use the questionsJson if it's already an object
            var questions = (typeof questionsJson === 'string') ? JSON.parse(questionsJson) : questionsJson;

            console.log("Parsed Questions:", questions);
            console.log("Type of Parsed Questions:", typeof questions);
            console.log("Is Array:", Array.isArray(questions));

            if (Array.isArray(questions)) {
                var questionsHtml = '';
                questions.forEach(function(question) {
                    questionsHtml += '<div class="question">';
                    questionsHtml += '<h2>' + question.title + '</h2>';
                    questionsHtml += '<ul>';
                    // Iterate through all possible options dynamically
                    for (var key in question) {
                        if (key.startsWith('R') && question[key]) {
                            questionsHtml += '<li>' + key + ': ' + question[key] + '</li>';
                        }
                    }
                    questionsHtml += '</ul>';
                    questionsHtml += '<p>Respuesta Correcta: ' + question.Correct_response_text + '</p>';
                    questionsHtml += '</div>';
                });

                $('#questions-container').html(questionsHtml);
            } else {
                console.error("Questions is not an array:", questions);
                $('#questions-container').html('<p>Data format is incorrect.</p>');
            }
        } catch (e) {
            console.error("Failed to parse JSON:", e);
            $('#questions-container').html('<p>Unable to load questions.</p>');
        }
    });
});
