<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country')->nullable();
            $table->date('founded')->nullable(); // дата основания (храним как date)
            $table->string('president')->nullable();
            $table->string('stadium')->nullable();
            $table->string('capacity')->nullable();
            $table->text('trophies')->nullable();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable(); // путь к загруженной картинке
            $table->timestamps();
            $table->softDeletes(); // для Soft Deletes (расширенный уровень)
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
