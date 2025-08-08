<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;

class DepartmentCreate extends Component
{
    public string $name = '';

    protected array $rules = [
        'name' => 'required|string|max:255|unique:departments,name',
    ];

    public function render()
    {
        return view('livewire.department-create');
    }

    public function submitForm(): void
    {
        $this->validate();

        Department::create(['name' => $this->name]);

        $this->dispatch('departmentSaved', __('Department successfully created.'));
    }
}
