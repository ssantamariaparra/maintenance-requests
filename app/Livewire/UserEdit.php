<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class UserEdit extends Component
{
    public $userId;
    public $name;
    public $email;
    public $password;
    public $role_id;
    public $departments = [];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
            'password' => 'nullable|min:8',
            'role_id' => 'required|exists:roles,id',
            'departments' => 'nullable|array',
            'departments.*' => 'exists:departments,id',
        ];
    }

    /**
     * When the component is mounted, load the user's data into the form.
     */
    public function mount($userId)
    {
        $this->userId = $userId;
        $user = User::findOrFail($userId);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role_id = $user->role_id;
        $this->departments = $user->departments->pluck('id')->toArray();
    }

    /**
     * Render the component's view.
     */
    public function render()
    {
        $allRoles = Role::all();
        $allDepartments = Department::all();
        return view('livewire.user-edit', [
            'allRoles' => $allRoles,
            'allDepartments' => $allDepartments,
        ]);
    }

    /**
     * Handle the form submission to update the user.
     */
    public function submitForm()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
        ];

        // Only update the password if a new one was entered.
        if (!empty($this->password)) {
            $userData['password'] = Hash::make($this->password);
        }

        $user->update($userData);
        $user->departments()->sync($this->departments);

        // Dispatch an event to the parent component to return to the list view.
        $this->dispatch('userSaved', __('User successfully updated.'));
    }
}
