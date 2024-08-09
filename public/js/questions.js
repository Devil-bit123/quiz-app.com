console.log('questions.js is loaded');

// Selecciona el contenedor de preguntas y los botones
const container = document.getElementById('questions-container');
const user = JSON.parse(container.getAttribute('data-user'));
const test = JSON.parse(container.getAttribute('data-test'));

console.log('User data:', user.id);

const prevButton = document.getElementById('prev-button');
const nextButton = document.getElementById('next-button');
const timerDisplay = document.getElementById('timer'); // Añade un contenedor para el temporizador

if (!container || !prevButton || !nextButton || !timerDisplay) {
    console.error('Container, buttons, or timer display not found');
}

const questions = container.querySelectorAll('.question');
let currentQuestionIndex = 0;
const responses = []; // Array para guardar todas las respuestas

let examDuration = document.getElementById('drationInMins').value; // Duración del examen en minutos, debe ser pasada desde el servidor
let timer;
let timerExpired = false; // Variable de bandera para evitar múltiples llamadas a generateFinalJSON

function startTimer(duration) {
    let timerSeconds = duration * 60;

    timer = setInterval(function () {
        let minutes = Math.floor(timerSeconds / 60);
        let seconds = timerSeconds % 60;

        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        timerDisplay.textContent = minutes + ':' + seconds;

        if (--timerSeconds < 0) {
            clearInterval(timer);
            timerDisplay.textContent = '00:00';
            if (!timerExpired) { // Verifica si el tiempo ya expiró para evitar múltiples alertas
                timerExpired = true; // Establece la bandera para indicar que el tiempo ha expirado
                alert('Tiempo expirado');
                handleTimeExpiration(); // Genera y guarda el JSON final cuando se agota el tiempo
            }
        }
    }, 1000);
}

function getCurrentQuestionData() {
    const question = questions[currentQuestionIndex];
    const title = question.querySelector('p').textContent;
    const answers = ['R1', 'R2', 'R3', 'R4', 'R5'].reduce((acc, key) => {
        const input = question.querySelector(`input[value="${key}"]`);
        if (input) {
            acc[key] = input.nextElementSibling.textContent;
        }
        return acc;
    }, {});

    const selectedInput = question.querySelector('input:checked');
    const userResponseIndex = selectedInput ? selectedInput.value : null;
    const userResponseText = userResponseIndex ? question.querySelector(`input[value="${userResponseIndex}"]`).nextElementSibling.textContent : null;

    return {
        title,
        ...answers,
        Correct_response_index: question.getAttribute('data-correct-response-index'),
        Correct_response_text: question.getAttribute('data-correct-response-text'),
        User_response_index: userResponseIndex,
        User_response_text: userResponseText,
    };
}

function saveResponse() {
    const currentQuestionData = getCurrentQuestionData();
    responses[currentQuestionIndex] = currentQuestionData;
    console.log('Response saved:', currentQuestionData);
}

function showQuestion(index) {
    questions.forEach((question, i) => {
        question.style.display = i === index ? 'block' : 'none';
    });

    prevButton.disabled = index === 0;

    // Mostrar el botón de guardar en la última pregunta
    if (index === questions.length - 1) {
        nextButton.textContent = 'Guardar';
        nextButton.id = 'save-button'; // Cambia el ID del botón para identificarlo fácilmente
    } else {
        nextButton.textContent = 'Siguiente';
        nextButton.id = 'next-button';
    }
}

function handleTimeExpiration() {
    // Asegúrate de que todas las preguntas sin respuesta tengan valores predeterminados
    questions.forEach((_, index) => {
        if (!responses[index]) {
            const question = questions[index];
            const title = question.querySelector('p').textContent;
            const answers = ['R1', 'R2', 'R3', 'R4', 'R5'].reduce((acc, key) => {
                const input = question.querySelector(`input[value="${key}"]`) ;
                if (input) {
                    acc[key] = input.nextElementSibling.textContent;
                }
                return acc;
            }, {});

            responses[index] = {
                title,
                ...answers,
                Correct_response_index: question.getAttribute('data-correct-response-index'),
                Correct_response_text: question.getAttribute('data-correct-response-text'),
                User_response_index: '9999',
                User_response_text: 'N/R',
            };
        }
    });
    generateFinalJSON();
}

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}


// function generateFinalJSON() {
//     // Guarda la última respuesta antes de generar el JSON
//     saveResponse();

//     // Compila el JSON final con todas las respuestas
//     const finalJSON = JSON.stringify(responses, null, 2);
//     console.log('Final responses JSON:', finalJSON);

//     const dataToSend = {
//         id_Test: test.id, // Aquí debes colocar el ID del test
//         id_User: user.id, // Aquí debes colocar el ID del usuario
//         responses: finalJSON,
//         score: '0', // Función para calcular la puntuación
//         status: 'completed' // Puedes definir el estado según tu lógica
//     };

//     // Enviar los datos al servidor
//     fetch('/admin/store/responses', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': getCsrfToken()
//         },
//         body: JSON.stringify(dataToSend)
//     }).then(response => response.json())
//       .then(data => console.log('Server response:', data))
//       .catch(error => console.error('Error:', error));
// }


function generateFinalJSON() {
    // Guarda la última respuesta antes de generar el JSON
    saveResponse();

    // Compila el JSON final con todas las respuestas
    const finalJSON = JSON.stringify(responses, null, 2);
    console.log('Final responses JSON:', finalJSON);

    const dataToSend = {
        id_Test: test.id, // Aquí debes colocar el ID del test
        id_User: user.id, // Aquí debes colocar el ID del usuario
        responses: finalJSON,
        score: '0', // Función para calcular la puntuación
        status: 'completed' // Puedes definir el estado según tu lógica
    };

    // Enviar los datos al servidor
    fetch('/admin/store-responses', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify(dataToSend)
    }).then(response => response.json())
      .then(data => {
          console.log('Server response:', data);

          // Verifica si el resultado es correcto
          if (data.success) {
              // Redirige a la nueva ruta si el resultado es correcto
              window.location.href = '/admin'; // Reemplaza '/ruta/deseada' con la ruta a la que quieres redirigir
          } else {
              // Manejo de errores o resultados incorrectos
              alert('Hubo un problema con el envío de datos.');
          }
      })
      .catch(error => {
          console.error('Error:', error);
          alert('Ocurrió un error al intentar enviar los datos.');
      });
}



function validateCurrentQuestion() {
    const question = questions[currentQuestionIndex];
    const selectedInput = question.querySelector('input:checked');
    return selectedInput !== null;
}

prevButton.addEventListener('click', function () {
    if (currentQuestionIndex > 0) {
        saveResponse();
        currentQuestionIndex--;
        showQuestion(currentQuestionIndex);
    }
});

nextButton.addEventListener('click', function () {
    if (nextButton.id === 'save-button') {
        // Asegúrate de que la última pregunta tenga una respuesta antes de guardar
        if (validateCurrentQuestion()) {
            generateFinalJSON();
            // El botón de guardar no se debe deshabilitar, solo mostrar el JSON
            alert('Tus respuestas han sido guardadas. Revisa la consola para el JSON.');
        } else {
            alert('Por favor, responde a la última pregunta antes de guardar.');
        }
    } else {
        if (validateCurrentQuestion()) {
            saveResponse();
            if (currentQuestionIndex < questions.length - 1) {
                currentQuestionIndex++;
                showQuestion(currentQuestionIndex);
            }
        } else {
            alert('Por favor, responde a la pregunta actual antes de continuar.');
        }
    }
});

// Muestra la primera pregunta inicialmente
showQuestion(currentQuestionIndex);

// Inicia el temporizador con la duración del examen pasada desde el servidor
startTimer(examDuration);
