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
                    <th scope="col">{{ English::Test_questions_info_text }}</th>
                    <th scope="col">{{ English::Test_duration_mins_text }}</th>
                    <th scope="col">{{ English::Planification_text }}</th>
                    <th scope="col">{{ English::Courses_text }}</th>
                    <th scope="col">{{ English::Actions_text }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tests as $test)
                    <tr>
                        <td>{{ $test->question_number }}</td>
                        <td>{{ $test->duration_in_minutes }}</td>
                        <td>{{ $test->bank->planification->name }}</td>
                        <td>
                            @foreach ($test->bank->planification->courses as $course)
                                {{ $course->name }}
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('test.edit', ['test' => $test->id]) }}" class="btn btn-warning" style="text-decoration: none">{{ English::Update_text }}</a>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-testid="{{ $test->id }}">{{ English::Delete_text }}</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
                <button type="button" class="btn btn-primary" data-dismiss="modal">{{ English::Cancel_text }}</button>
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
        $('#deleteModal').on('show.bs.modal', function (event) {
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
