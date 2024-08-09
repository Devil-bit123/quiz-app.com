<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_Test');
            $table->unsignedBigInteger('id_User');
            $table->json('responses');
            $table->decimal('score');
            $table->string('status');
            $table->timestamps();

            $table->foreign('id_Test')->references('id')->on('tests')->onDelete('cascade');
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
        Schema::dropIfExists('responses');
    }
}
