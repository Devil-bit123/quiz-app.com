@extends('voyager::master')

@section('content')

@php
use App\Constants\English;
@endphp

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


@foreach ($courses as $course)
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $course->name }}</h5>
                <p class="card-text">{{ $course->description }}</p>

                @if ($user->role->name == 'docente')
                    <form action="{{ route('courses-user.matriculation', ['course' => $course->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">{{ English::Teach_text }}</button>
                    </form>
                @elseif ($user->role->name == 'alumno')
                    <form action="{{ route('courses-user.matriculation', ['course' => $course->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">{{ English::Sign_up_text }}</button>
                    </form>
                @endif

            </div>
        </div>
    </div>
@endforeach



@stop

@section('javascript')



@stop
