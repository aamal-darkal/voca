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
        Schema::create('phrase_word', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phrase_id')->constrained()->onDelete('cascade');
            $table->foreignId('word_id')->constrained()->onDelete('cascade');
            $table->string('translate');
            $table->integer('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phrase_word');
    }
};
