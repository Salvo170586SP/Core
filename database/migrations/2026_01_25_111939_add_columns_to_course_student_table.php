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
        Schema::table('course_student', function (Blueprint $table) {
            $table->boolean('is_active')->default(false)->after('student_id');
            $table->string('badge_number')->nullable()->after('is_active');
            $table->timestamp('issued_at')->nullable()->after('badge_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_student', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->dropColumn('badge_number');
            $table->dropColumn('issued_at');
        });
    }
};
