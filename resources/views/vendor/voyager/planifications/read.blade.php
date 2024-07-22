@extends('voyager::master')

@section('content')
    <div class="container mt-4">
        <h2>Planificaciones del Curso: {{ $course->name }}</h2>

        @foreach ($planificationsByType as $type => $planifications)
            <div class="card mb-4">
                <div class="card-header">
                    <h3>{{ ucfirst($type) }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($planifications as $planificationCourse)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $planificationCourse->planification->name }}</h5>
                                        <p class="card-text">{{ $planificationCourse->planification->description }}</p>
                                        <p class="card-text">
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($planificationCourse->planification->date)->format('d/m/Y') }}</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
