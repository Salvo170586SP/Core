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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('fiscal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('cap')->nullable();
            $table->string('city_birth')->nullable();
            $table->date('date_birth')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
