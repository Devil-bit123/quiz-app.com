<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanificationCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planification_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_Course');
                $table->unsignedBigInteger('id_Planification');
            $table->timestamps();

            // Adding foreign keys
            $table->foreign('id_Course')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('id_Planification')->references('id')->on('planifications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planification_courses');
    }
}
