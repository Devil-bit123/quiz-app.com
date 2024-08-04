@extends('voyager::master')


@section('content')


@php
use App\Constants\English;
@endphp

<div class="custom-form">
    @if (isset($error))
    <div class="alert alert-danger">
        {{ $error }}
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success">
    {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
    {{ session('error') }}
    </div>
    @endif

    <h1>{{ English::Configuration_text }} {{ English::Test_title_text }} {{  $planification->name }}</h1>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('store.test') }}" method="POST">
                @csrf

                <input type="hidden" id="FormControlInputBank" value="{{ $banks->id }}" name="bank" />

                <h2>{{ English::Total_questions_text }} {{ count(json_decode($banks->questions_json)) }}</h2>
                    <div class="mb-3">
                    <label for="FormControlInputNumberQuestions" class="form-label">{{ English::Number_questions }}</label>
                    <input type="number" class="form-control" id="FormControlInputNumberQuestions" name="questions" placeholder="{{ English::Number_questions }}" required>
                    <div id="questionAlert" class="alert alert-danger mt-2" style="display: none;"></div>
                </div>

                <div class="mb-3">
                    <label for="FormControlInputTimePicker" class="form-label">{{ English::Duration_test }}</label>
                    <input type="text" class="form-control" id="FormControlInputTimePicker" name="appt" required />

                    <input type="hidden" id="FormControlInputMinutes" name="minutes" />
                </div>

                <input class="btn btn-primary" type="submit" value="Save" />
            </form>

        </div>
      </div>


        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                flatpickr("#FormControlInputTimePicker", {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true
                });
            });

            function getMinutes(timeStr) {
            const [hours, minutes] = timeStr.split(':').map(Number);
            return (hours * 60) + minutes;
        }

        document.getElementById('FormControlInputTimePicker').addEventListener('input', function() {
            const timePickerValue = this.value;
            if (timePickerValue) {
                const minutes = getMinutes(timePickerValue);
                console.log(minutes);
                document.getElementById('FormControlInputMinutes').value = minutes;
            } else {
                document.getElementById('FormControlInputMinutes').value = '';
            }
        });

        document.getElementById('FormControlInputNumberQuestions').addEventListener('input', function() {
            const numberQuestions = Number(this.value);
            const totalQuestions = {{ count(json_decode($banks->questions_json)) }};
            const alertDiv = document.getElementById('questionAlert');

            if (numberQuestions > totalQuestions) {
                alertDiv.textContent = `The number of questions cannot be greater than the total (${totalQuestions}).`;
                alertDiv.style.display = 'block';
            } else {
                alertDiv.style.display = 'none';
            }
        });


        </script>



</div>
@endsection
