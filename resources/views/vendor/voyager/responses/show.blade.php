@extends('voyager::master')


@section('content')

@php
use App\Constants\English;
@endphp



    <div class="container mt-4">
        <h1>{{ English::Response_text }}</h1>
        @foreach ($response->responses as $res)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $res['title'] }}</h5>
                    <ul>
                        @foreach ($res as $key => $value)
                            @if (in_array($key, ['R1', 'R2', 'R3', 'R4', 'R5']))
                                <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                            @endif
                        @endforeach
                    </ul>
                    <p><strong>{{ English::User_Response_text }}:</strong> {{ $res['User_response_text'] }} ({{ $res['User_response_index'] }})</p>
                    <p><strong>{{ English::Correct_Response_text }}:</strong> {{ $res['Correct_response_text'] }} ({{ $res['Correct_response_index'] }})</p>
                </div>
            </div>
        @endforeach

        <h3>{{ English::Score_text }} : {{ $response->score }}</h3>

        <form action="{{ url()->previous() }}" method="GET">
            <button type="submit" class="btn btn-primary">{{ English::Back_text }}</button>
        </form>
    </div>
@endsection
