@extends('voyager::master')

@section('content')

@php
use App\Constants\English;
@endphp

<div class="container mt-4">
    <h2>{{ $course->name }} {{ English::Planification_text }}</h2>

    @switch($user->role->name)
        @case('docente')
            @foreach ($planifications as $planification)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $planification->planification->name  }}</h5>
                        <p class="card-text">{{ $planification->planification->description  }}</p>
                        <p class="card-text">
                            <small class="text-muted">{{ $planification->planification->date  }}</small>
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('planification.configurate',['planification'=>$planification->planification->id]) }}" class="btn btn-primary">{{ English::Configuration_text }}</a>
                        <a href="{{ route('planification.edit', ['id' => $planification->planification->id]) }}" class="btn btn-warning">{{ English::Update_text }}</a>
                        <a href="#" class="btn btn-danger">{{ English::Delete_text }}</a>
                    </div>
                </div>
            @endforeach
        @break

        @case('alumno')
            @foreach ($planifications as $planification)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $planification->planification->name  }}</h5>
                        <p class="card-subtitle">{{ $planification->planification->type  }}</p>
                        <p class="card-text">{{ $planification->planification->description  }}</p>
                        <p class="card-text">
                            <small class="text-muted">{{ $planification->planification->date  }}</small>
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">

                        <a href="#" class="btn btn-warning">{{ English::Take_text }}</a>
                    </div>
                </div>
            @endforeach
        @break

        @default
            <p>{{ English::Planification_text_default }}</p>
        @break
    @endswitch
</div>

@endsection
