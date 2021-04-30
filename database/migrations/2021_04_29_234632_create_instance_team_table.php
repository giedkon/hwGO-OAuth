<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstanceTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instance_team', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('team_id')->references('id')->on('teams')->cascadeOnDelete();
            $table->foreignId('instance_id')->references('id')->on('instances')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_instance_user');
    }
}
