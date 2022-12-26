<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->timestamp('start');
            $table->timestamp('end');
            $table->integer('duration');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
//            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calendars', function(Blueprint $table)
        {
//            $table->dropIndex(['user_id']);
        });
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('calendars');
    }
};
