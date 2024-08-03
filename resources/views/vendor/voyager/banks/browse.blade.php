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


    <div class="container">
        <h1>{{ English::Bank_title_text }}</h1>

        @if ($user->role->name == 'docente' || $user->role->name == 'admin')
            <a href="{{ route('bank.add') }}" class="btn btn-primary">{{ English::Add_text }} {{ English::Bank_text }}</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ English::Course_text }}</th>
                        <th>{{ English::Planification_text }}</th>
                        <th>{{ English::Questions_text }}</th>
                        <th>{{ English::Actions_text }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banks as $bank)
                        <tr>
                            <td>
                                @foreach ($bank->planification->courses as $course)
                                    {{ $course->name }}
                                    @if (!$loop->last)
                                        , <!-- Add a comma between course names if there are multiple -->
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ $bank->planification->name }}</td>
                            <td>

                                <button type="button" class="btn btn-info btn-lg"
                                data-toggle="modal"
                                data-target="#myModal"
                                data-questions="{{ $bank->questions_json }}">
                                {{ English::Show_questions_text }}
                            </button>

                            </td>
                            <td>
                                <div class="btn-group me-2" role="group" aria-label="First group">
                                    <a href="/admin/edit-bank/{{ $bank->id }}" type="button"
                                        style="text-decoration:none" class="btn btn-warning">Edit</a>

                                        <form action="{{ route('bank.delete', ['banks' => $bank->id]) }}" method="DELETE" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Questions</h4>
                </div>
                <div class="modal-body">
                    <div id="questions-container"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Load your custom script -->
    <script src="{{ asset('js/show-modal.js') }}"></script>



@endsection
