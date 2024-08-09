<?php

namespace App\Helpers;

use App\Models\Banks;
use App\Models\Responses;

class TestHelper
{


    public static function random_questions(Banks $bank, $amount)
    {
        // Decodifica el JSON a un array asociativo
        $questions = json_decode($bank->questions_json, true);

        // Verifica si la decodificación fue exitosa y si se obtuvo un array
        if (!is_array($questions)) {
            return "Error al decodificar las preguntas del banco.";
        }

        $total_questions = count($questions);

        // Verifica si la cantidad solicitada de preguntas no excede el total disponible
        if ($amount > $total_questions) {
            return "El número solicitado de preguntas excede el total de preguntas disponibles.";
        } else {
            // Selecciona preguntas aleatorias
            $random_keys = array_rand($questions, $amount);

            // Si $amount es 1, array_rand devuelve un solo elemento en lugar de un array
            if ($amount == 1) {
                $random_keys = [$random_keys];
            }

            // Selecciona las preguntas aleatorias usando las claves obtenidas
            $random_questions = array_map(function ($key) use ($questions) {
                return $questions[$key];
            }, $random_keys);

            return $random_questions;
        }
    }

    public static function score(Responses $response)
    {
        // Decodifica las respuestas JSON
        $responses = json_decode($response->responses, true);

        // Inicializa el contador de respuestas correctas
        $correctAnswers = 0;
        $totalQuestions = count($responses);

        // Recorre cada pregunta y compara las respuestas del usuario con las correctas
        foreach ($responses as $question) {
            // Verifica si el índice de respuesta del usuario coincide con el índice correcto
            // y si el texto de la respuesta del usuario coincide con el texto correcto
            if ($question['Correct_response_index'] === $question['User_response_index'] &&
                $question['Correct_response_text'] === $question['User_response_text']) {
                $correctAnswers++;
            }
        }

        // Calcula el puntaje como un número entre 0 y 10
        $score = ($correctAnswers / $totalQuestions) * 10;

        return $score;
    }






}
