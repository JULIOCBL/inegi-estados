<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('geo_code', 2)->index();
            $table->string('code', 2)->unique();
            $table->string('name')->index();
            $table->string('short_name', 20)->nullable();
            $table->unsignedBigInteger('population')->index();
            $table->unsignedBigInteger('female_population')->nullable();
            $table->unsignedBigInteger('male_population')->nullable();
            $table->unsignedBigInteger('inhabited_homes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
