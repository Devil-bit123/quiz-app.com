<?php

namespace App\Constants;

use App\Models\Planification;

class English
{
    /**
     * Button Actions
     */
    const View_text = 'View';
    const Take_text = 'Take';
    const Configuration_text = 'Configurate';
    const Update_text = 'Update';
    const Delete_text = 'Delete';
    const Save_text = 'Save';
    const Add_text = 'Add';
    const Select_text = 'Select an option';
    const Actions_text = 'Actions';
    const Show_questions_text = 'Show Questions';
    const Cancel_text = 'Cancel';
    const Delete_modal_title = 'Do you want to delete';

    /**
     * Courses
     */

     const Course_text = 'Course';
     const Courses_text = 'Courses';

    /**
     * Planifications
     */
    const Planification_text = 'Plans';
    const Planification_text_default = 'No schedules available.';
    const Planification_delete_modal_title = 'Do you want to delete';
    const Planification_delete_modal_error = 'Your planification have a question bank or info asociated';
    const Planification_delete_modal_success = 'Planification deleted';


    /**
     * Errors
     */
    const Validation_text_error_for_planification = 'The planning date cannot be less than the current day.';
    const Date_text_error_for_planification = 'The planning date cannot be less than the current day.';
    const Type_text_error_for_planification = 'Please select a type.';
    const Description_text_error_for_planification = 'Please enter a description.';
    const Name_text_error_for_planification = 'Please enter a name.';

    /***
     * Banks
     */
    const Bank_title_text = 'Questions Bank';
    const Bank_text = 'Bank';
    const Questions_text = 'Questions';
    const Configuations_text = 'Configurations';
    const Answer_text = 'Answer';
    const Enter_question_title= 'Enter a question title';
    const Enter_answer_text= 'Enter an answer';
    const Correct_answer_text = 'Select the correct answer';
    const Select_course_text = 'Select the course';


    /**
     * Partials
     */
    const Test_title_text = 'Test';
    const Task_title_text = 'Task';
    const Class_title_text = 'Class';

    /**
     * Tests
     */
    const Number_questions = 'Enter the number of questions';
    const Duration_test = 'Enter the duration of the test';
    const Total_questions_text = 'Total number of questions of:';
    const Test_empty_text = 'No associated test found for this bank.';
    const Test_info_text = 'Test Info';
    const Test_questions_info_text = 'Questions number';
    const Test_duration_info_text = 'Duration';
    const Test_duration_mins_text = 'Duration in minutes';
    const Test_configuration_text = 'Configuration';

}
