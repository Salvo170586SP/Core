<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('level')->nullable(); //['entry level', 'medium', 'hoìigh', 'very high'] 
            $table->integer('duration_hours');
            $table->integer('max_students')->default(20);
            $table->integer('min_students')->default(5);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status'); //['pianificato', 'attivo', 'completato', 'annullato'] 
            $table->string('center')->nullable(); //centro scolastico
            $table->decimal('price', 8, 2)->nullable();
            $table->boolean('certification')->default(false);
            $table->string('depliant_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
