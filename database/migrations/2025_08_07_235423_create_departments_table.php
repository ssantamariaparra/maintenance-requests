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
        // Creates the 'departments' table to store hotel departments like 'Housekeeping' or 'Maintenance'.
        Schema::create('departments', function (Blueprint $table) {
            $table->id(); // Primary key for the department
            $table->string('name')->unique(); // The name of the department (e.g., "Front Desk")
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
