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
        // This is a pivot table to create a many-to-many relationship between users (employees) and departments.
        Schema::create('department_user', function (Blueprint $table) {
            $table->id(); // Primary key for the pivot entry

            // Foreign key for the user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Foreign key for the department
            $table->foreignId('department_id')->constrained()->onDelete('cascade');

            $table->timestamps();

            // Ensure a user can't be in the same department twice.
            $table->unique(['user_id', 'department_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_user');
    }
};
