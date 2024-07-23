<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Banks;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Planification;
use Illuminate\Support\Facades\Auth;

class BanksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = Auth::user();
        $banks = Banks::with('planification')->get();
        //dd($banks);
        return view('vendor.voyager.banks.browse',compact('banks','user'));
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
        $userInfo = User::findOrFail($user->id);

        $courses = $userInfo->course()->with('course')->get()->map(function ($courseUser) {
            return $courseUser->course;
        });
        //dd($courses);
        $plans = Planification::where('type','=','Test')->get();
        return view('vendor.voyager.banks.add', compact('plans','courses'));
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
        Banks::create([
            'id_Planification'=>$request->plan_id,
            'questions_json'=>$request->test_json
        ]);
        $user = Auth::user();
        $banks = Banks::with('planification')->get();
        return view('vendor.voyager.banks.browse',compact('banks','user'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banks  $banks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banks $banks)
    {
        //
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
