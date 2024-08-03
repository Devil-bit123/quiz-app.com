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
                        <h5 class="card-title">{{ $plan->planification->name }}</h5>
                        <p class="card-text">{{ $plan->planification->type }}</p>
                        <p class="card-text">{{ $plan->planification->description }}</p>
                        <p class="card-text">
                            <small class="text-muted">{{ $plan->planification->date }}</small>
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('planification.configurate', ['planification' => $plan->planification->id]) }}" class="btn btn-primary">{{ English::Configuration_text }}</a>
                        <a href="{{ route('planification.edit', ['id' => $plan->planification->id]) }}" class="btn btn-warning">{{ English::Update_text }}</a>
                        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#myModal"
                           data-id="{{ $plan->planification->id }}"
                           data-name="{{ $plan->planification->name }}"
                           data-type="{{ $plan->planification->type }}"
                           data-description="{{ $plan->planification->description }}">
                           {{ English::Delete_text }}</a>
                    </div>
                </div>
            @endforeach
        @break

        @case('admin')
            @foreach ($planifications as $plan)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $plan->planification->name }}</h5>
                        <p class="card-text">{{ $plan->planification->type }}</p>
                        <p class="card-text">{{ $plan->planification->description }}</p>
                        <p class="card-text">
                            <small class="text-muted">{{ $plan->planification->date }}</small>
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('planification.configurate', ['planification' => $plan->planification->id]) }}" class="btn btn-primary">{{ English::Configuration_text }}</a>
                        <a href="{{ route('planification.edit', ['id' => $plan->planification->id]) }}" class="btn btn-warning">{{ English::Update_text }}</a>
                        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#myModal"
                           data-id="{{ $plan->planification->id }}"
                           data-name="{{ $plan->planification->name }}"
                           data-type="{{ $plan->planification->type }}"
                           data-description="{{ $plan->planification->description }}">
                           {{ English::Delete_text }}</a>
                    </div>
                </div>
            @endforeach
        @break

        @case('alumno')
            @foreach ($planifications as $plan)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $plan->planification->name }}</h5>
                        <p class="card-text">{{ $plan->planification->type }}</p>
                        <p class="card-text">{{ $plan->planification->description }}</p>
                        <p class="card-text">
                            <small class="text-muted">{{ $plan->planification->date }}</small>
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

{{-- Modal --}}
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{  English::Planification_delete_modal_title }}</h4>
      </div>
      <div class="modal-body">
        <p id="planification-details"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="delete-confirm">Delete</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var selectedPlanificationId;

        $('#myModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Botón que disparó el modal
            var id = button.data('id');
            var name = button.data('name');
            var type = button.data('type');
            var description = button.data('description');

            selectedPlanificationId = id;

            // Actualiza el contenido del modal
            var modal = $(this);
            modal.find('#planification-details').text('Name: ' + name + ', Type: ' + type + ', Description: ' + description);
        });

        $('#delete-confirm').on('click', function () {
            if (selectedPlanificationId) {
                $.ajax({
                    url: '/admin/delete-planification/' + selectedPlanificationId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#alert').removeClass('alert-danger').addClass('alert-success');
                        } else {
                            $('#alert').removeClass('alert-success').addClass('alert-danger');
                        }
                        $('#alert').text(response.message).show();
                        $('#myModal').modal('hide');
                    },
                    error: function() {
                        $('#alert').removeClass('alert-success').addClass('alert-danger');
                        $('#alert').text('{{ English::Planification_delete_modal_error }}').show();
                        $('#myModal').modal('hide');
                    }
                });
            }
        });
    });
</script>
@stop
