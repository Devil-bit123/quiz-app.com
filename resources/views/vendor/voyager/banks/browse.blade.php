@extends('voyager::master')

@section('content')

@php
use App\Constants\English;
@endphp


<div class="container">
    <h1>{{ English::Bank_title_text }}</h1>

    @if ($user->role->name == 'docente' || $user->role->name == 'admin')

    <a href="{{ route('bank.add') }}" class="btn btn-primary">{{ English::Add_text }} {{ English::Bank_text }}</a>

    <table class="table table-bordered">
        <thead>
            <tr>

                <th>{{ English::Planification_text }}</th>
                <th>{{ English::Questions_text }}</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($banks as $question)
                <tr>

                    <td>{{ $question->planification->name  }}</td>
                    <td>{{ $question->questions_json }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @endif

</div>

@endsection
