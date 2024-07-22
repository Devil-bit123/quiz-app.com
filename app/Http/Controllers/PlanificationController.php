<?php

namespace App\Http\Controllers;

use App\Models\Course;
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

        // Obtener todos los cursos relacionados con el usuario
        $courses = $user->courseUsers->map(function ($courseUser) {
            return $courseUser->course;
        });

        // Verificar si hay cursos
        if ($courses->isNotEmpty()) {
            return view('vendor.voyager.planifications.browse', compact('courses','user'));
        } else {
            // Pasar el mensaje de error a la vista
            return view('vendor.voyager.planifications.browse', [
                'courses' => collect(), // Asegúrate de pasar una colección vacía para evitar errores
                'error' => 'No estás matriculado en ningún curso',
                'user'=>'user'
            ]);
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
         $planifications = PlanificationCourse::where('id_Course', $course->id)->with('planification')->get();

         // Agrupar las planificaciones por tipo
         $planificationsByType = $planifications->groupBy(function($planificationCourse) {
             return $planificationCourse->planification->type;
         });

         return view('vendor.voyager.planifications.read', compact('planificationsByType', 'course'));
     }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Planification  $planification
     * @return \Illuminate\Http\Response
     */
    public function show(Planification $planification)
    {
        dd($planification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planification  $planification
     * @return \Illuminate\Http\Response
     */
    public function edit(Planification $planification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planification  $planification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Planification $planification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planification  $planification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Planification $planification)
    {
        //
    }
}
