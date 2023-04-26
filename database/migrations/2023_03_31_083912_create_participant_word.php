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
        Schema::create('participant_phrase_word', function (Blueprint $table) {
            $table->foreignId('participant_id')->constrained()->onDelete('cascade');
            $table->foreignId('phrase_word_id')->references('id')->on('phrase_word')->onDelete('cascade');
            $table->primary(['participant_id' , 'phrase_word_id'  ]);                        
            $table->char('status' ,1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participant_word');
    }
};
