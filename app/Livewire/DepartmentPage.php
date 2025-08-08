<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class DepartmentPage extends Component
{
    public bool $creatingDepartment = false;
    public bool $editingDepartment = false;
    public ?int $selectedDepartmentId = null;

    protected $listeners = [
        'createDepartment' => 'showCreateForm',
        'editDepartment' => 'showEditForm',
        'departmentSaved' => 'closeForms',
        'formCancelled' => 'closeForms',
    ];

    public function showCreateForm(): void
    {
        $this->editingDepartment = false;
        $this->creatingDepartment = true;
    }

    public function showEditForm(int $departmentId): void
    {
        $this->selectedDepartmentId = $departmentId;
        $this->creatingDepartment = false;
        $this->editingDepartment = true;
    }

    public function closeForms(string $message = ''): void
    {
        $this->creatingDepartment = false;
        $this->editingDepartment = false;
        $this->reset('selectedDepartmentId');

        if ($message) {
            session()->flash('message', $message);
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.department-page');
    }
}
