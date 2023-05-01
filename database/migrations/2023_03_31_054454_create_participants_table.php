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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('name' , 50);
            $table->string('email' , 100)->unique();
            $table->string('avatar')->default('no-image.png');
            $table->char('theme_app' , 1)->default('L');;
            $table->boolean('is_admob')->default(false);
            $table->integer('learn_word_count')->default(0);
            $table->integer('learn_phrase_count')->default(0); 
            $table->foreignId('lang_app')->nullable()->references('id')->on('languages')->onDelete('set null');            
            $table->foreignId('dialect_id')->constrained();
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
        Schema::dropIfExists('participants');
    }
};
