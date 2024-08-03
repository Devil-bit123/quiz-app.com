<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Banks;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Planification;
use App\Models\PlanificationCourse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BanksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $user = Auth::user();

        $banks = Banks::with('planification.courses')->get();

        //dd($banks);

        return view('vendor.voyager.banks.browse', compact('banks', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$courses = Course::all();

        $user = Auth::user();

        if($user->role->name == 'admin'){

        $courses = Course::all();
        //dd($courses);
        $plans = Planification::where('type', '=', 'Test')->get();
        return view('vendor.voyager.banks.add', compact('plans', 'courses'));

        }else{

        $userInfo = User::findOrFail($user->id);

        $courses = $userInfo->course()->with('course')->get()->map(function ($courseUser) {
            return $courseUser->course;
        });
        //dd($courses);
        $plans = Planification::where('type', '=', 'Test')->get();
        return view('vendor.voyager.banks.add', compact('plans', 'courses'));


        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request);
        $request->validate([
            'plan_id' => 'required|integer|exists:planifications,id',
            'test_json' => 'required|json',
        ]);
        $course_id=$request->course_id;
        $plan_id = $request->plan_id;
        $course_test = $request->test_json;

        // Crear un nuevo registro en la tabla Banks
        Banks::create([
            'id_Planification' => $plan_id,
            'questions_json' => $course_test
        ]);

        // PlanificationCourse::create([
        //     'id_Course' => $course_id,
        //     'id_Planification' => $plan_id
        // ]);

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Recuperar todos los bancos con la relación planification
        $banks = Banks::with('planification')->get();

        // Pasar los datos a la vista
        return view('vendor.voyager.banks.browse', compact('banks', 'user'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banks  $banks
     * @return \Illuminate\Http\Response
     */
    public function show(Banks $banks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banks  $banks
     * @return \Illuminate\Http\Response
     */
    public function edit(Banks $banks)
    {
        //dd($banks);
        //dd($banks);
        // Pasar el JSON de preguntas al view
        return view('partials.details-test', [
            'banks' => $banks,
            'questionsJson' => json_decode($banks->questions_json, true) // Decodificar el JSON a un array PHP
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banks  $banks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validar que el campo questions_json esté presente y sea un JSON válido
        $validator = Validator::make($request->all(), [
            'questions_json' => 'required|json',
            'bank_id' => 'required' // Validar que el ID del banco sea válido
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Encontrar el banco por ID
        $bank = Banks::find($request->input('bank_id'));

        if (!$bank) {
            return response()->json(['success' => false, 'message' => 'Bank not found'], 404);
        }

        // Actualizar el modelo con el nuevo JSON
        $bank->questions_json = $request->input('questions_json');
        $bank->save();

        return response()->json(['success' => true], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banks  $banks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banks $banks)
    {
        //
        //dd($banks);
        $banks->delete();

        return redirect()->back()->with('success', 'Bank deleted successfully');
    }

    public function loadPartialView($type)
    {
        $view = '';

        $type = strtolower($type);
        //dd($type);

        switch ($type) {
            case 'test':
                $view = 'partials.test';
                break;
            case 'task':
                $view = 'partials.task';
                break;
            case 'class':
                $view = 'partials.class';
                break;
            default:
                abort(404);
        }

        return view($view);
    }


    public function receiveJson(Request $request)
    {
        $jsonData = $request->input();
        return response()->json(['success' => true, 'data' => $jsonData]);
    }
}
