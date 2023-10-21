<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('abilities_to_roles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ability_id');
            $table->foreign('ability_id')->references('id')->on('abilities');
            $table->bigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abilities_to_roles');
    }
};
