<?php

namespace App\Http\Controllers;

use App\Models\Planification;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // Verificar si el usuario no tiene el rol de 'admin' o 'docente'
        if (!($user->role->name == 'admin' || $user->role->name == 'docente')) {
            return redirect()->back()->withErrors(['message' => 'No tienes permisos para acceder a esta página.']);
        } else {
            $tests = Test::with(['bank.planification', 'bank.planification.courses'])->get();
            //dd($tests);
            return view('vendor.voyager.tests.browse', compact('tests', 'user'));
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
        //
        //dd($request);
        Test::create([
            'id_Bank'=> $request->bank,
            'question_number'=> $request->questions,
            'duration_in_minutes'=> $request->minutes
        ]);

        return redirect()->route('planification.index')->with('success', 'Test creado exitosamente.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        //
        //dd($test->bank->id_Planification);
        $planification=Planification::find($test->bank->id_Planification);
        $banks = $planification->bank;
        $course = $planification->courses;
        return view('vendor.voyager.tests.update',compact('test','planification','banks','course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        //
        //dd($request);
        //dd($test);

        $test->id = $request->test;
        $test->id_Bank = $request->bank;
        $test->question_number = $request->questions;
        $test->duration_in_minutes = $request->minutes;
        $test->save();

        return redirect()->route('planification.index')->with('success', 'Test editado exitosamente.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        //
        //dd($test);
        $test->delete();
        return redirect()->route('planification.index')->with('success', 'Test eliminado exitosamente.');
    }
}
