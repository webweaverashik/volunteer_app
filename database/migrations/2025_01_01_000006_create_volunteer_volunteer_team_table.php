<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('volunteer_volunteer_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->constrained()->cascadeOnDelete()->index('idx_vvt_volunteer');
            $table->foreignId('volunteer_team_id')->constrained()->cascadeOnDelete()->index('idx_vvt_team');
            $table->timestamps();
            $table->unique(['volunteer_id', 'volunteer_team_id'], 'vvt_unique_volunteer_team');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_volunteer_team');
    }
};
