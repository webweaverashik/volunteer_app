<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();

            $table->string('full_name')->index('idx_volunteers_full_name');
            $table->string('mobile')->index('idx_volunteers_mobile');
            $table->string('nid')->nullable()->index('idx_volunteers_nid');

            $table->boolean('sylhet3_resident')->default(false)->index('idx_volunteers_sylhet3');

            $table->foreignId('upazila_id')->nullable()->constrained()->nullOnDelete()->index('idx_volunteers_upazila');

            $table->string('union_name')->index('idx_volunteers_union_name');

            $table->text('current_address');

            $table->string('voting_center')->nullable()->index('idx_volunteers_voting_center');

            $table->integer('age');

            $table->foreignId('occupation_id')->nullable()->constrained()->nullOnDelete()->index('idx_volunteers_occupation');

            $table->string('reference')->nullable();

            $table->string('weekly_hours')->index('idx_volunteers_weekly_hours');
            $table->string('preferred_time')->index('idx_volunteers_preferred_time');

            $table->text('comments')->nullable();
            $table->string('other_team_description')->nullable();

            $table
                ->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending')
                ->index('idx_volunteers_status');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};
