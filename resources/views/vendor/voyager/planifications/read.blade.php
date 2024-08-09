@extends('voyager::master')

@section('content')

    @php
        use App\Constants\English;
    @endphp

    <div class="container mt-4">
        <h2>{{ $course->name }} {{ English::Planification_text }}</h2>

        <div class="alert alert-primary" role="alert" id="alert" style="display: none;">
        </div>

        @switch($user->role->name)
            @case('docente')
                @foreach ($planifications as $plan)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $plan->name }}</h5>
                            <p class="card-text">{{ $plan->type }}</p>
                            <p class="card-text">{{ $plan->description }}</p>
                            <p class="card-text">
                                <small class="text-muted">{{ $plan->date }}</small>
                            </p>

                            @if ($plan->hasTest)
                                @foreach ($plan->bank->tests as $test)
                                    <div>
                                        <p><strong>{{ English::Test_info_text }}</strong></p>
                                        <p><strong>{{ English::Test_questions_info_text }}</strong> {{ $test->question_number }}</p>
                                        <p><strong>{{ English::Test_duration_info_text }}:</strong>
                                            {{ $test->duration_in_minutes }}
                                            minutes</p>
                                    </div>
                                    @if ($test->responses)
                                        <a href="{{ route('show.scores', ['planification' => $plan->id]) }}"
                                            class="btn btn-primary">{{ English::View_text }} {{ count($test->responses) }}
                                            {{ English::Responses_text }} </a>
                                    @endif
                                @endforeach
                                <a href="{{ route('test.edit', ['test' => $test->id]) }}"
                                    class="btn btn-primary">{{ English::Update_text }} {{ English::Test_title_text }}</a>

                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#deleteModal"
                                    data-testid="{{ $test->id }}">{{ English::Delete_text }}
                                    {{ English::Test_title_text }}</button>

                                <a href="{{ route('planification.edit', ['id' => $plan->id]) }}"
                                    class="btn btn-warning">{{ English::Update_text }} {{ English::Planification_text }}</a>
                                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#myModal"
                                    data-id="{{ $plan->id }}" data-name="{{ $plan->name }}" data-type="{{ $plan->type }}"
                                    data-description="{{ $plan->description }}">
                                    {{ English::Delete_text }} {{ English::Planification_text }}</a>
                        </div>
                    @else
                        <p>{{ English::Test_empty_text }}</p>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('planification.configurate', ['planification' => $plan->id]) }}"
                                class="btn btn-primary">{{ English::Configuration_text }} {{ English::Test_title_text }}</a>
                            <a href="{{ route('planification.edit', ['id' => $plan->id]) }}"
                                class="btn btn-warning">{{ English::Update_text }} {{ English::Planification_text }}</a>
                            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#myModal"
                                data-id="{{ $plan->id }}" data-name="{{ $plan->name }}" data-type="{{ $plan->type }}"
                                data-description="{{ $plan->description }}">
                                {{ English::Delete_text }} {{ English::Planification_text }}</a>
                @endif
            </div>
            </div>
            @endforeach
        @break

        @case('admin')
            @foreach ($planifications as $plan)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $plan->name }}</h5>
                        <p class="card-text">{{ $plan->type }}</p>
                        <p class="card-text">{{ $plan->description }}</p>
                        <p class="card-text">
                            <small class="text-muted">{{ $plan->date }}</small>
                        </p>
                        @if ($plan->hasTest)
                            @foreach ($plan->bank->tests as $test)
                                <div>
                                    <p><strong>{{ English::Test_info_text }}</strong></p>
                                    <p><strong>{{ English::Test_questions_info_text }}</strong> {{ $test->question_number }}</p>
                                    <p><strong>{{ English::Test_duration_info_text }}:</strong>
                                        {{ $test->duration_in_minutes }}
                                        minutes</p>
                                </div>
                                @if ($test->responses)
                                    <a href="{{ route('show.scores', ['planification' => $plan->id]) }}"
                                        class="btn btn-primary">{{ English::View_text }} {{ count($test->responses) }}
                                        {{ English::Responses_text }} </a>
                                @endif
                            @endforeach
                            <a href="{{ route('test.edit', ['test' => $test->id]) }}"
                                class="btn btn-primary">{{ English::Update_text }} {{ English::Test_title_text }}</a>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#deleteModal"
                                data-testid="{{ $test->id }}">{{ English::Delete_text }}
                                {{ English::Test_title_text }}</button>

                            <a href="{{ route('planification.edit', ['id' => $plan->id]) }}"
                                class="btn btn-warning">{{ English::Update_text }} {{ English::Planification_text }}</a>
                            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#myModal"
                                data-id="{{ $plan->id }}" data-name="{{ $plan->name }}" data-type="{{ $plan->type }}"
                                data-description="{{ $plan->description }}">
                                {{ English::Delete_text }} {{ English::Planification_text }}</a>
                    </div>
                @else
                    <p>{{ English::Test_empty_text }}</p>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('planification.configurate', ['planification' => $plan->id]) }}"
                            class="btn btn-primary">{{ English::Configuration_text }} {{ English::Test_title_text }}</a>
                        <a href="{{ route('planification.edit', ['id' => $plan->id]) }}"
                            class="btn btn-warning">{{ English::Update_text }} {{ English::Planification_text }}</a>
                        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#myModal"
                            data-id="{{ $plan->id }}" data-name="{{ $plan->name }}" data-type="{{ $plan->type }}"
                            data-description="{{ $plan->description }}">
                            {{ English::Delete_text }} {{ English::Planification_text }}</a>
            @endif
            </div>
            </div>
            @endforeach
        @break

        @case('alumno')
            @foreach ($planifications as $plan)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $plan->name }}</h5>
                        <p class="card-text">{{ $plan->type }}</p>
                        <p class="card-text">{{ $plan->description }}</p>
                        <p class="card-text">
                            <small class="text-muted">{{ $plan->date }}</small>
                        </p>

                        @if ($plan->hasTest)
                            @php
                                $today = \Carbon\Carbon::now()->format('Y/m/d');

                                $planDate = \Carbon\Carbon::parse($plan->date)->format('Y/m/d');
                            @endphp

                            @foreach ($plan->bank->tests as $test)
                                <div>
                                    <p><strong>{{ English::Test_info_text }}</strong></p>
                                    <p><strong>{{ English::Test_questions_info_text }}</strong> {{ $test->question_number }}
                                    </p>
                                    <p><strong>{{ English::Test_duration_info_text }}:</strong>
                                        {{ $test->duration_in_minutes }}
                                        minutes</p>
                                </div>
                            @endforeach
                            @if ($today == $planDate)
                                <div class="card-footer d-flex justify-content-between">
                                    @if (!$test->userHasResponded)
                                        <a href="{{ route('responses.make', ['test' => $test->id]) }}"
                                            class="btn btn-warning">{{ English::Take_text }}</a>
                                    @endif
                                </div>
                            @elseif ($test->userHasResponded && $today >= $planDate)
                                <a href="{{ route('responses.show', ['response' => $test->userResponseId]) }}"
                                    class="btn btn-success">{{ English::View_text }}</a>
                            @endif
                    </div>
                @else
                    <p>{{ English::Test_empty_text }}</p>
            @endif
            </div>
            </div>
            @endforeach
        @break

        @default
            <p>{{ English::Planification_text_default }}</p>
        @break

    @endswitch
    </div>

    {{-- Modal --}}
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ English::Planification_delete_modal_title }}</h4>
                </div>
                <div class="modal-body">
                    <p id="planification-details"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"
                        data-dismiss="modal">{{ English::Cancel_text }}</button>
                    <button type="button" class="btn btn-danger"
                        id="delete-confirm">{{ English::Delete_text }}</button>
                </div>
            </div>
        </div>
    </div>





    <!-- Modal -->
    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ English::Delete_modal_title }}</h4>
                </div>
                {{-- <div class="modal-body">
                <p>{{ English::Delete_confirmation_text }}</p>
            </div> --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"
                        data-dismiss="modal">{{ English::Cancel_text }}</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ English::Delete_text }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var testId = button.data('testid');
                var modal = $(this);
                var deleteUrl = "{{ route('test.delete', ['test' => ':id']) }}";
                deleteUrl = deleteUrl.replace(':id', testId);
                modal.find('#deleteForm').attr('action', deleteUrl);
            });
        });
    </script>



@endsection

@section('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var selectedPlanificationId;

            $('#myModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Botón que disparó el modal
                var id = button.data('id');
                var name = button.data('name');
                var type = button.data('type');
                var description = button.data('description');

                selectedPlanificationId = id;

                // Actualiza el contenido del modal
                var modal = $(this);
                modal.find('#planification-details').text('Name: ' + name + ', Type: ' + type +
                    ', Description: ' + description);
            });

            $('#delete-confirm').on('click', function() {
                if (selectedPlanificationId) {
                    $.ajax({
                        url: '/admin/delete-planification/' + selectedPlanificationId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#alert').removeClass('alert-danger').addClass(
                                    'alert-success');
                            } else {
                                $('#alert').removeClass('alert-success').addClass(
                                    'alert-danger');
                            }
                            $('#alert').text(response.message).show();
                            $('#myModal').modal('hide');
                        },
                        error: function() {
                            $('#alert').removeClass('alert-success').addClass('alert-danger');
                            $('#alert').text(
                                    '{{ English::Planification_delete_modal_error }}')
                                .show();
                            $('#myModal').modal('hide');
                        }
                    });
                }
            });
        });
    </script>
@stop
