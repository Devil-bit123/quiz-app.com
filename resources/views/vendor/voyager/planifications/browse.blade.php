@extends('voyager::master')

@section('content')

@php
use App\Constants\English;
@endphp


    @if (isset($error))
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif



    @if ($courses->isNotEmpty())

        @foreach ($courses as $course)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->name }}</h5>
                        <p class="card-text">{{ $course->description }}</p>

                        @if ($user->role->name == 'docente' || $user->role->name == 'admin')
                            <button href="/course-details/{{ $course->id }}" type="submit" class="btn btn-primary"><a href="{{ route('courses.details', ['course' => $course->id]) }}" class="btn btn-primary">{{ English::Plan_text }}</a></button>
                            <button href="/show-planification/{{ $course->id }}" type="submit" class="btn btn-primary"><a href="{{ route('planification.details', ['course' => $course->id]) }}" class="btn btn-primary">{{ English::View_text }}</a></button>
                        @elseif ($user->role->name == 'alumno')
                        <button href="/show-planification/{{ $course->id }}" type="submit" class="btn btn-primary"><a href="{{ route('planification.details', ['course' => $course->id]) }}" class="btn btn-primary">{{ English::View_text }}</a></button>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>{{ English::Unaviable_courses_text }}</p>
    @endif
@stop
