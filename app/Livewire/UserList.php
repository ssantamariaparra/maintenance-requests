<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Department;
use App\Models\Role;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    public bool $showDeleteModal = false;
    public ?int $userToDeleteId = null;

    // Filter properties
    public string $searchName = '';
    public string $searchEmail = '';
    public ?string $searchRoleId = '';
    public ?string $searchDepartmentId = '';

    protected $listeners = ['userSaved' => '$refresh'];

    // Reset pagination when any filter is updated
    public function updating($property): void
    {
        if (in_array($property, ['searchName', 'searchEmail', 'searchRoleId', 'searchDepartmentId'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = User::with('role', 'departments');

        // Apply name filter
        if (!empty($this->searchName)) {
            $query->where('name', 'like', '%' . $this->searchName . '%');
        }
        
        // Apply email filter
        if (!empty($this->searchEmail)) {
            $query->where('email', 'like', '%' . $this->searchEmail . '%');
        }
        
        // Apply role filter
        if (!empty($this->searchRoleId)) {
            $query->where('role_id', $this->searchRoleId);
        }

        // Apply department filter
        if (!empty($this->searchDepartmentId)) {
            $query->whereHas('departments', function ($q) {
                $q->where('departments.id', $this->searchDepartmentId);
            });
        }

        $users = $query->latest()->paginate(10);
        $allRoles = Role::orderBy('name')->get();
        $allDepartments = Department::orderBy('name')->get();

        return view('livewire.user-list', [
            'users' => $users,
            'allRoles' => $allRoles,
            'allDepartments' => $allDepartments
        ]);
    }

    public function confirmDelete(int $userId): void
    {
        $this->userToDeleteId = $userId;
        $this->showDeleteModal = true;
    }

    public function deleteUser(): void
    {
        if ($this->userToDeleteId) {
            User::find($this->userToDeleteId)->delete();
            $this->dispatch('userSaved', __('User successfully deleted.'));
        }

        $this->showDeleteModal = false;
        $this->userToDeleteId = null;
    }

    /**
     * Clear all active filters.
     */
    public function clearFilters(): void
    {
        $this->reset(['searchName', 'searchEmail', 'searchRoleId', 'searchDepartmentId']);
    }
}
