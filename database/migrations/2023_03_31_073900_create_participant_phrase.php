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
        Schema::create('participant_phrase', function (Blueprint $table) {
            $table->primary(['participant_id' , 'phrase_id'  ]);            
            $table->foreignId('participant_id')->constrained()->onDelete('cascade');
            $table->foreignId('phrase_id')->constrained()->onDelete('cascade');
            $table->char('status' ,1)->comment('S => start , C => complete, X => skip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participant_phrase');
    }
};
