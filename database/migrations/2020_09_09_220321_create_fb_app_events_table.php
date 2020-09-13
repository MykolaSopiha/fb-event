<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFbAppEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fb_app_events', function (Blueprint $table) {
            $table->id();

            $table->string('value_to_sum')->nullable();
            $table->jsonb('parameters')->nullable();

            $table->unsignedBigInteger('fb_app_id');
            $table->unsignedBigInteger('fb_event_id');

            $table->timestamps();

            $table->foreign('fb_app_id')
                ->on('fb_apps')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');

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
        Schema::dropIfExists('fb_app_events');
    }
}
