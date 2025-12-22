<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('mobile');
            $table->string('nid')->nullable();
            $table->boolean('sylhet3_resident')->default(false);
            $table->foreignId('upazila_id')->nullable()->constrained()->nullOnDelete();
            $table->string('union_name');
            $table->text('current_address');
            $table->string('voting_center')->nullable();
            $table->integer('age');
            $table->foreignId('occupation_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reference')->nullable();
            $table->string('weekly_hours')->nullable();
            $table->string('preferred_time')->nullable();
            $table->text('comments')->nullable();
            $table->string('other_team_description')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};
