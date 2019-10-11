<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('chat_session_id');
            $table->string('name')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('address')->nullable();
            $table->string('poli')->nullable();
            $table->string('sequence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitors');
    }
}
