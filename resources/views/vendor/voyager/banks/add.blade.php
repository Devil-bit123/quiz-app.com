@extends('voyager::master')

@section('content')

@php
use App\Constants\English;
@endphp

<div class="container">
    <h1>{{ English::Add_text }} {{ English::Bank_text }}</h1>

    <form action="{{ route('bank.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="course_id">{{ English::Select_course_text }}</label>
            <select name="course_id" id="course_id" class="form-control" onchange="updatePlans()">
                <option value="">{{ English::Select_text }}</option>

                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="plan_id">{{ English::Planification_text }}</label>
            <select name="plan_id" id="plan_id" class="form-control" onchange="loadPartialView()">
                <!-- Plans will be populated based on the selected course -->
            </select>
        </div>

        <div id="partial-view-container"></div>

        <textarea style="display: none" name="test_json" id="test-json-field"></textarea>


        <button type="submit" class="btn btn-primary">{{ English::Add_text }}</button>
    </form>
</div>

@endsection

@section('javascript')

<script>
    // Function to update plans based on the selected course
// En tu vista Blade
function updatePlans() {
    var courseId = document.getElementById("course_id").value;
    var planSelect = document.getElementById("plan_id");

    // Limpia las opciones existentes
    planSelect.innerHTML = '<option value="">Select a plan</option>';

    // Obtén los planes basados en el curso seleccionado
    fetch(`/admin/plans?course_id=${courseId}`)
        .then(response => response.json())
        .then(plans => {
            plans.forEach(plan => {
                var option = document.createElement("option");
                option.value = plan.id;
                option.textContent = plan.name;
                option.dataset.type = plan.type;
                planSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching plans:', error));
}


    function loadPartialView() {
        var select = document.getElementById("plan_id");
        var selectedOption = select.options[select.selectedIndex];
        var selectedType = selectedOption.getAttribute('data-type');
        selectedType = selectedType.toLowerCase();
        var partialViewContainer = document.getElementById("partial-view-container");

        // Clear existing content
        partialViewContainer.innerHTML = '';

        if (selectedType) {
            fetch(`/admin/partials/${selectedType}`)
                .then(response => response.text())
                .then(data => {
                    partialViewContainer.innerHTML = data;
                    // Make sure to run the script after partial view is loaded
                })
                .catch(error => console.error('Error loading partial view:', error));
        }
    }

    function updateTestJsonField(jsonData) {
        var jsonField = document.getElementById('test-json-field');
        jsonField.value = jsonData;
    }

</script>

<script src="{{ asset('js/test.js') }}"></script>

@endsection
