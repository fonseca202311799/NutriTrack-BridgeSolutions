<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->json('dietary_preferences')->nullable()->after('grade_level');
            $table->string('allergies')->nullable()->after('dietary_preferences');
            $table->string('conditions')->nullable()->after('allergies');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['dietary_preferences','allergies','conditions']);
        });
    }
};
