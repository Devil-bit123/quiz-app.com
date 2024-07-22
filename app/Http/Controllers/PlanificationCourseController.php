<?php

namespace App\Http\Controllers;

use App\Models\PlanificationCourse;
use Illuminate\Http\Request;

class PlanificationCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PlanificationCourse  $planificationCourse
     * @return \Illuminate\Http\Response
     */
    public function show(PlanificationCourse $planificationCourse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PlanificationCourse  $planificationCourse
     * @return \Illuminate\Http\Response
     */
    public function edit(PlanificationCourse $planificationCourse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PlanificationCourse  $planificationCourse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlanificationCourse $planificationCourse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlanificationCourse  $planificationCourse
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlanificationCourse $planificationCourse)
    {
        //
    }
}
