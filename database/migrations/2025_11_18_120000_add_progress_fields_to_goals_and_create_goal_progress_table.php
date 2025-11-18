<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('goals', function (Blueprint $table) {
            $table->integer('target_value')->nullable()->after('target');
            $table->string('target_unit')->nullable()->after('target_value');
            $table->integer('current_value')->default(0)->after('target_unit');
            $table->date('due_date')->nullable()->after('current_value');
        });

        Schema::create('goal_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goal_id')->constrained('goals')->onDelete('cascade');
            $table->integer('value');
            $table->timestamp('recorded_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goal_progress');
        Schema::table('goals', function (Blueprint $table) {
            $table->dropColumn(['target_value','target_unit','current_value','due_date']);
        });
    }
};
