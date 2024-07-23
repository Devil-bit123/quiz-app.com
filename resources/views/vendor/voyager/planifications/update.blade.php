@extends('voyager::master')

@section('content')

@php
use App\Constants\English;
@endphp


    <div class="container mt-4">
        <h2>{{ English::Update_text }} {{ $planification->name  }}</h2>
        <form method="POST" action="{{ route('planification.update', $planification->id) }}" class="needs-validation" novalidate>
            @csrf
            @method('POST')

            <input type="hidden" name="_method" value="POST">

            <div class="mb-3">
                <label for="InputName" class="form-label">Name</label>
                <input type="text" class="form-control" id="InputName" name="name" value="{{ old('name', $planification->name) }}" required>
                <div class="invalid-feedback">
                    {{ English::Name_text_error_for_planification }}
                </div>
            </div>

            <div class="mb-3">
                <label for="InputDescription" class="form-label">Description</label>
                <textarea class="form-control" id="InputDescription" name="description" rows="3" required>{{ old('description', $planification->description) }}</textarea>
                <div class="invalid-feedback">
                    {{ English::Description_text_error_for_planification }}
                </div>
            </div>

            <div class="mb-3">
                <label for="InputType" class="form-label">Type</label>
                <select class="form-select" id="InputType" name="type" required>
                    <option value="" disabled>Seleccione un tipo</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}" {{ $type == $planification->type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    {{ English::Type_text_error_for_planification }}
                </div>
            </div>

            <div class="mb-3">
                <label for="InputDate" class="form-label">Date</label>
                <input type="date" class="form-control" id="InputDate" name="date" value="{{ old('date', $planification->date) }}" required>
                <div class="invalid-feedback">
                    {{ English::Date_text_error_for_planification }}
                </div>
            </div>

            <button type="submit" class="btn btn-primary">{{ English::Update_text }}</button>
        </form>
    </div>
@endsection

@section('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                const dateInput = document.getElementById('InputDate');
                const selectedDate = new Date(dateInput.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Set hours to 0 for accurate comparison

                if (selectedDate < today) {
                    event.preventDefault(); // Prevent form submission
                    dateInput.classList.add('is-invalid'); // Add Bootstrap invalid class
                    dateInput.nextElementSibling.textContent = 'La fecha de planificación no puede ser menor al día actual.';
                } else {
                    dateInput.classList.remove('is-invalid'); // Remove invalid class if date is valid
                }
            });
        });
    </script>
@endsection
