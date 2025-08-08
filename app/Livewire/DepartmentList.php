<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;
use Livewire\WithPagination;

class DepartmentList extends Component
{
    use WithPagination;

    public bool $showDeleteModal = false;
    public ?int $departmentToDeleteId = null;

    // Filter property
    public string $searchName = '';

    protected $listeners = ['departmentSaved' => '$refresh'];

    // Reset pagination when the filter is updated
    public function updatingSearchName(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Department::withCount('users');

        if (!empty($this->searchName)) {
            $query->where('name', 'like', '%' . $this->searchName . '%');
        }

        $query->orderBy('name');

        $departments = $query->latest()->paginate(10);
        return view('livewire.department-list', ['departments' => $departments]);
    }

    public function confirmDelete(int $departmentId): void
    {
        $department = Department::withCount('users')->find($departmentId);

        if ($department && $department->users_count > 0) {
            session()->flash('error', __('This department cannot be deleted because it has users assigned to it.'));
            $this->dispatch('$refresh');
            return;
        }

        $this->departmentToDeleteId = $departmentId;
        $this->showDeleteModal = true;
    }

    public function deleteDepartment(): void
    {
        if ($this->departmentToDeleteId) {
            Department::find($this->departmentToDeleteId)->delete();
            $this->dispatch('departmentSaved', __('Department successfully deleted.'));
        }

        $this->showDeleteModal = false;
        $this->departmentToDeleteId = null;
    }

    public function clearFilters(): void
    {
        $this->reset('searchName');
    }
}
