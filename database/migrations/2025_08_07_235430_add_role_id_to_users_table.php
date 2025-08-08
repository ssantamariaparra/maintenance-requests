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
        // Modifies the existing 'users' table to add the role_id column.
        Schema::table('users', function (Blueprint $table) {
            // Foreign key for the role. Each user has one role.
            // The constrained() method will assume a 'roles' table with an 'id' column.
            // onDelete('cascade') means if a role is deleted, users with that role are also deleted.
            $table->foreignId('role_id')->after('id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // It's important to drop the foreign key constraint before dropping the column.
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
