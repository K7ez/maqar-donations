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
        Schema::create('beneficiary_families', function (Blueprint $table) {
            $table->id();
            $table->string('family_name');
            $table->string('national_id')->unique();
            $table->unsignedSmallInteger('members_count')->default(1);
            $table->string('housing_program');
            $table->string('status')->default('active')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiary_families');
    }
};
