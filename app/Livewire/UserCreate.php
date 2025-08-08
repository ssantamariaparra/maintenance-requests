<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class UserCreate extends Component
{
    public $name;
    public $email;
    public $password;
    public $role_id = 2; // Default to 'Employee' role
    public $departments = [];

    /**
     * Validation rules for creating a new user.
     */
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|min:8',
        'role_id' => 'required|exists:roles,id',
        'departments' => 'nullable|array',
        'departments.*' => 'exists:departments,id',
    ];

    /**
     * Render the component's view.
     */
    public function render()
    {
        $allRoles = Role::all();
        $allDepartments = Department::all();
        return view('livewire.user-create', [
            'allRoles' => $allRoles,
            'allDepartments' => $allDepartments,
        ]);
    }

    /**
     * Handle the form submission to create the user.
     */
    public function submitForm()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role_id' => $this->role_id,
        ]);

        $user->departments()->sync($this->departments);

        // Dispatch an event to the parent component to return to the list view.
        $this->dispatch('userSaved', __('User successfully created.'));
    }
}
