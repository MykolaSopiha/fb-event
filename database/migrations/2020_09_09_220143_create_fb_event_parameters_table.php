<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFbEventParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fb_event_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['int', 'float', 'string', 'logical']);
            $table->string('description');
            $table->unsignedBigInteger('fb_event_id');
            $table->timestamps();

            $table->foreign('fb_event_id')
                ->on('fb_events')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fb_event_parameters');
    }
}
