@extends('voyager::master')


@section('content')
    @php
        use App\Constants\English;
    @endphp


    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"> {{ English::User_title_text }} </th>
                        <th scope="col"> {{ English::Responses_text }} </th>
                        <th scope="col"> {{ English::Score_text }} </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($responses as $response)
                    <tr>
                        <th>{{ $response->user->name }}</th>
                        <td>
                            <a href="{{ route('responses.show',['response'=>$response->id]) }}" class="btn btn-success" style="text-decoration: none">
                                {{ English::Responses_text }}
                            </a>
                        </td>
                        <td>{{ $response->score }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
