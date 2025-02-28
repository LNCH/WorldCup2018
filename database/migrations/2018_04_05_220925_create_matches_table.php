<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp("match_date")->nullable()->default(null);
            $table->string("channel");
            $table->unsignedInteger("home_team_id");
            $table->unsignedInteger("away_team_id");
            $table->unsignedInteger("home_score")->nullable();
            $table->unsignedInteger("away_score")->nullable();
            $table->timestamps();
            
            $table->foreign("home_team_id")
                ->references("id")
                ->on("teams");
            
            $table->foreign("away_team_id")
                ->references("id")
                ->on("teams");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
