@extends('voyager::master')

@section('content')
    <div class="container mt-4">
        <h2>Planificación</h2>
        <form id="planificationForm" class="needs-validation" novalidate method="POST" action="{{ route('planification.create') }}">
            @csrf

            <input type="hidden" name="course_id" value="{{ $course->id }}" class="form-control" id="InputCourseId" aria-describedby="nameHelp" required>

            <div class="mb-3">
                <label for="InputName" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="InputName" aria-describedby="nameHelp" required>
                <div class="invalid-feedback">
                    Por favor, ingrese un nombre.
                </div>
            </div>
            <div class="mb-3">
                <label for="InputDescription" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="InputDescription" rows="3" required></textarea>
                <div class="invalid-feedback">
                    Por favor, ingrese una descripción.
                </div>
            </div>

            <div class="mb-3">
                <label for="InputType" class="form-label">Type</label>
                <select name="type" class="form-select" id="InputType" required>
                    <option value="" disabled selected>Seleccione un tipo</option>
                    @foreach ($types as $type)
                        <option value="{{ ucfirst($type) }}">{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Por favor, seleccione un tipo.
                </div>
            </div>

            <div class="mb-3">
                <label for="InputDate" class="form-label">Date</label>
                <input type="date" name="date" class="form-control" id="InputDate" required>
                <div class="invalid-feedback">
                    La fecha de planificación no puede ser menor al día actual.
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <div id="errorAlert" class="alert alert-danger mt-3" style="display: none;" role="alert">
            La fecha de planificación no puede ser menor al día actual o no ha seleccionado un tipo válido.
        </div>
    </div>

    @section('javascript')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('planificationForm');
                const dateInput = document.getElementById('InputDate');
                const typeInput = document.getElementById('InputType');
                const errorAlert = document.getElementById('errorAlert');

                form.addEventListener('submit', function(event) {
                    const selectedDate = new Date(dateInput.value);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0); // Set hours to 0 for accurate comparison

                    let valid = true;

                    if (dateInput.value === '' || selectedDate < today) {
                        valid = false;
                        dateInput.classList.add('is-invalid'); // Add Bootstrap invalid class
                    } else {
                        dateInput.classList.remove('is-invalid'); // Remove invalid class if date is valid
                    }

                    if (typeInput.value === '' || typeInput.value === null) {
                        valid = false;
                        typeInput.classList.add('is-invalid'); // Add Bootstrap invalid class
                    } else {
                        typeInput.classList.remove('is-invalid'); // Remove invalid class if type is valid
                    }

                    if (!valid) {
                        event.preventDefault(); // Prevent form submission
                        errorAlert.style.display = 'block'; // Show error alert
                    } else {
                        errorAlert.style.display = 'none'; // Hide error alert if valid
                    }
                });
            });
        </script>
    @stop
@endsection
