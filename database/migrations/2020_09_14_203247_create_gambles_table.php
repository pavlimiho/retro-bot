<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gambles', function (Blueprint $table) {
            $table->id()->unique();
            $table->foreignId('starter_id')->constrained('members')->cascadeOnDelete();
            $table->unsignedInteger('amount');
            $table->foreignId('winner_id')->constrained('members')->cascadeOnDelete();
            $table->foreignId('loser_id')->constrained('members')->cascadeOnDelete();
            $table->unsignedInteger('amount_won');
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
        Schema::dropIfExists('gambles');
    }
}
