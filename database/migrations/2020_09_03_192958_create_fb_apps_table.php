<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFbAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fb_apps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fb_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('key')->unique();
            $table->timestamps();

            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        DB::query('CREATE INDEX fb_apps_key_hash_index ON fb_apps USING hash (key);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::query('drop index fb_apps_key_hash_index;');

        Schema::dropIfExists('fb_apps');
    }
}
