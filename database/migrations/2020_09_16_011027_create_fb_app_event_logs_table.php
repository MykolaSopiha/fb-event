<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFbAppEventLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fb_app_event_logs', function (Blueprint $table) {
            $table->id();
            $table->string('desc')->nullable();
            $table->json('json_content')->nullable();
            $table->json('json_response')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('fb_app_event_id');
            $table->timestamps();

            $table->foreign('fb_app_event_id')
                ->references('id')
                ->on('fb_app_events')
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
        Schema::dropIfExists('fb_app_event_logs');
    }
}
