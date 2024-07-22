<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_user', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_Course');
                $table->unsignedBigInteger('id_User');
                $table->timestamps();

                // Adding foreign keys
                $table->foreign('id_Course')->references('id')->on('courses')->onDelete('cascade');
                $table->foreign('id_User')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_user');
    }
}
