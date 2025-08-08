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
        // Creates the 'roles' table to store user roles like 'Administrator' and 'Employee'.
        Schema::create('roles', function (Blueprint $table) {
            $table->id(); // Primary key for the role
            $table->string('name')->unique(); // The name of the role (e.g., "Administrator")
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
