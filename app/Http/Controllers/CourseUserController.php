<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseUser;
use Illuminate\Http\Request;
use App\Models\Planification;
use Illuminate\Support\Facades\Auth;

class CourseUserController extends Controller
{
    public function Index()
    {
        $user = Auth::user();
        $courses = Course::all();

        return view('vendor.voyager.course-user.browse', compact('courses', 'user'));
    }

    public function Matriculation($courseId)
    {
        $user = Auth::user();

        // Verificar si el curso existe
        $course = Course::find($courseId);
        if (!$course) {
            return redirect()->back()->with('error', 'El curso no existe.');
        }

        // Verificar si el usuario ya está matriculado en el curso
        $isEnrolled = CourseUser::where('id_User', $user->id)
                                ->where('id_Course', $courseId)
                                ->exists();

        if ($isEnrolled) {
            // El usuario ya está matriculado en el curso
            return redirect()->back()->with('error', 'Ya estás matriculado en este curso.');
        } else {
            // El usuario no está matriculado en el curso, proceder con la matriculación
            CourseUser::create([
                'id_User' => $user->id,
                'id_Course' => $courseId,
            ]);

            return redirect()->back()->with('success', 'Te has matriculado en el curso exitosamente.');
        }
    }

    public function details(Course $course){
        //dd($course);
        $types = Planification::getTypes();
        return view('vendor.voyager.planifications.create',compact('course','types'));
    }


}
