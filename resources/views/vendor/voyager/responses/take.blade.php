@extends('voyager::master')

@section('content')
    @php
        use App\Constants\English;
    @endphp


    <div class="card">
        <div class="card-body">

            <h2>{{ English::Test_title_text }} {{ $test->bank->planification->name }}</h2>

            <ul class="list-group">
                <li class="list-group-item">{{ English::Total_questions_text }} {{ $test->question_number }}</li>
                <li id="drationInMins" value="{{ $test->duration_in_minutes }}" class="list-group-item">{{ English::Test_duration_mins_text }} {{ $test->duration_in_minutes }}</li>


                <button type="button" class="btn btn-warning btn-lg" data-toggle="modal"
                    data-target="#myModal">{{ English::Take_now_text }}</button>
            </ul>

            <div id="questionsContainer" class="mt-3">
                <!-- Las preguntas se cargarán aquí -->
            </div>

        </div>
    </div>


    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ English::Confirmation_title_text }}</h4>
                </div>
                <div class="modal-body">
                    <p>{{ English::Confirmation_body_text }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">{{ English::Cancel_text }}</button>
                    <button type="button" class="btn btn-danger" id="takeButton">{{ English::Take_text }}</button>
                </div>
            </div>

        </div>
    </div>
@endsection

{{-- @section('javascript')
    <script>
        $(document).ready(function() {

            $('#takeButton').click(function() {
                $('#myModal').modal('hide');
                $.ajax({
                    url: '{{ route('tests.takeQuestions', ['test' => $test->id]) }}',
                    method: 'GET',
                    success: function(data) {
                        $('#questionsContainer').html(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading questions:', error);
                    }
                });
            });

            // Event handler for the next question button
            $(document).on('click', '#nextQuestionButton', function() {
                // Logic to save the current question's response and load the next question
            });
        });
    </script>
@endsection --}}


@section('javascript')
    <script>
        $(document).ready(function() {


            $('#takeButton').click(function() {
                $('#myModal').modal('hide');
                $.ajax({
                    url: '{{ route('tests.takeQuestions', ['test' => $test->id]) }}',
                    method: 'GET',
                    success: function(data) {
                        $('#questionsContainer').html(data);
                        startTimer(examDuration); // Inicia el temporizador cuando las preguntas se muestran
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading questions:', error);
                    }
                });
            });

            // // Event handler for the next question button
            // $(document).on('click', '#nextQuestionButton', function() {
            //     // Logic to save the current question's response and load the next question
            // });

        });
    </script>
@endsection
