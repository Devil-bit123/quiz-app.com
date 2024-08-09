<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\User;
use App\Models\Course;
use App\Constants\English;
use App\Models\CourseUser;
use Illuminate\Http\Request;
use App\Models\Planification;
use App\Models\PlanificationCourse;
use Illuminate\Support\Facades\Auth;


class PlanificationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        //dd($user->course);

        if ($user->role->name == 'admin') {
            $courses = Course::all();
            return view('vendor.voyager.planifications.browse', compact('courses', 'user'));
        } else {

            $courses = $user->courses;
            //dd($courses);
            // Verificar si hay cursos
            if ($courses->isNotEmpty()) {
                return view('vendor.voyager.planifications.browse', compact('courses', 'user'));
            } else {
                // Pasar el mensaje de error a la vista
                return view('vendor.voyager.planifications.browse', [
                    'courses' => collect(), // Asegúrate de pasar una colección vacía para evitar errores
                    'error' => 'No estás matriculado en ningún curso',
                    'user' => 'user'
                ]);
            }
        }
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
            'course_id' => 'required|integer|exists:courses,id',
        ]);

        // Crear la planificación
        $planification = Planification::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'date' => $request->date,
        ]);

        // Crear la relación en PlanificationCourse
        PlanificationCourse::create([
            'id_Course' => $request->course_id,
            'id_Planification' => $planification->id,
        ]);

        return redirect()->route('planification.index')->with('success', 'Planificación creada exitosamente.');
    }


    /**
     * Mostrar la planificacion de un curso
     */

    public function details(Course $course)
    {
        $user = Auth::user();
        //$planifications = PlanificationCourse::where('id_Course', $course->id)->with('planification')->get();

        $planifications = Planification::whereHas('courses', function ($query) use ($course) {
            // Especifica a qué tabla pertenece el id en la subconsulta
            $query->where('courses.id', $course->id);
        })->with('courses')->get();

        // Verificar si el banco de preguntas asociado tiene un test
        foreach ($planifications as $planification) {
            // Verificar si el banco de preguntas existe
            if ($planification->bank) {
                // Verificar si el banco de preguntas tiene un test
                $planification->hasTest = $planification->bank->tests()->exists();
            } else {
                $planification->hasTest = false;
            }
        }

        //dd($planifications);

        return view('vendor.voyager.planifications.read', compact('planifications', 'course', 'user'));
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Planification  $planification
     * @return \Illuminate\Http\Response
     */
    public function show(Planification $planification)
    {
        //dd($planification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planification  $planification
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $planification = Planification::findOrFail($id);
        $types = ['test', 'task', 'class'];

        // Convierte la fecha en formato `Y-m-d` para la vista
        $planification->date = \Carbon\Carbon::parse($planification->date)->format('Y-m-d');

        return view('vendor.voyager.planifications.update', compact('planification', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planification  $planification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //dd($request);

        // Buscar la planificación
        $planification = Planification::findOrFail($id);

        // Actualizar la planificación
        $planification->update([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'date' => $request->date,
        ]);

        return redirect()->route('planification.index')->with('success', 'Planificación actualizada exitosamente.');
    }

    /**
     * Configurate specific planification
     */

    public function configurate(Request $request, Planification $planification)
    {


        $banks = $planification->bank;
        $course = $planification->courses;

        return view('vendor.voyager.planifications.configurate', compact('planification', 'banks'));
    }

    public function getPlansByCourse(Request $request)
    {
        $courseId = $request->query('course_id');

        $plans = PlanificationCourse::where('id_Course', $courseId)
            ->whereHas('planification', function ($query) {
                $query->where('type', Planification::TYPE_TEST)
                    ->whereDoesntHave('bank');
            })
            ->with('planification')
            ->get()
            ->map(function ($planificationCourse) {
                return $planificationCourse->planification;
            });

        //($plans);

        return response()->json($plans);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planification  $planification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Planification $planification)
    {
        $bank = $planification->bank;
        if (!$bank) {
            $planification->delete();
            return response()->json(['success' => true, 'message' => English::Planification_delete_modal_success]);
        } else {
            return response()->json(['success' => false, 'message' => English::Planification_delete_modal_error]);
        }
    }
}
