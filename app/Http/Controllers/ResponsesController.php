<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Helpers\TestHelper;
use App\Models\Responses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResponsesController extends Controller
{
    public function take(Test $test)
    {
        // Obtén el usuario autenticado
        $user = Auth::user();

        //$random_questions = TestHelper::random_questions($test->bank,$test->question_number);

        // Filtra las respuestas del usuario para el examen específico
        $hasResponded = $user->responses->where('id_Test', $test->id);

        // Comprueba si la colección filtrada tiene algún elemento
        if ($hasResponded->isNotEmpty()) {
            return redirect()->back();
        } else {
            return view('vendor.voyager.responses.take', compact('test'));
        }
    }

    public function takeQuestions(Test $test)
    {
        $user = Auth::user();
        $random_questions = TestHelper::random_questions($test->bank, $test->question_number);
        //dd($random_questions);
        return view('partials.questions', compact('test', 'random_questions', 'user'));
    }

    public function store(Request $request)
    {

        $data = $request->all();
        $responses = json_decode($data['responses'], true);
        $response = Responses::create([
            'id_Test' => $data['id_Test'],
            'id_User' => $data['id_User'],
            'responses' => $data['responses'],
            'score' => 0, // Inicialmente el puntaje es 0
            'status' => $data['status']
        ]);

        $score = TestHelper::score($response);
        $response->update(['score' => $score]);

        //dd($response);

        return response()->json(['success' => 'true', 'message' => 'Data stored successfully', 'score' => $score]);
    }

    public function show(Responses $response)
    {
        $response->responses = json_decode($response->responses, true);
        return view('vendor.voyager.responses.show',compact('response'));
    }
}
