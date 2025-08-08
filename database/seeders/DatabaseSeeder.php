<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Temporarily disable foreign key checks to truncate tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Truncate tables to ensure a clean slate on each seed
        Role::truncate();
        Department::truncate();
        User::truncate();
        DB::table('department_user')->truncate(); // Truncate the pivot table

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Create Roles
        $adminRole = Role::create(['id' => 1, 'name' => 'Administrator']);
        $employeeRole = Role::create(['id' => 2, 'name' => 'Employee']);

        // 2. Create Departments
        $dept1 = Department::create(['name' => 'Dept 1']);
        $dept2 = Department::create(['name' => 'Dept 2']);
        $dept3 = Department::create(['name' => 'Dept 3']);

        // 3. Create Users
        // Create the administrator user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // IMPORTANT: Change this password
            'role_id' => $adminRole->id,
        ]);

        // Create the employee user
        $employeeUser = User::create([
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'password' => Hash::make('password'), // IMPORTANT: Change this password
            'role_id' => $employeeRole->id,
        ]);

        // 4. Attach Departments to the Employee User
        // This assumes you have the 'departments' relationship set up in your User model
        $employeeUser->departments()->attach([$dept1->id, $dept3->id]);
    }
}
