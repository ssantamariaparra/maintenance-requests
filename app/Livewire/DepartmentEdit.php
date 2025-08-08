<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;

class DepartmentEdit extends Component
{
    public int $departmentId;
    public string $name = '';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:departments,name,' . $this->departmentId,
        ];
    }

    public function mount(int $departmentId): void
    {
        $this->departmentId = $departmentId;
        $department = Department::findOrFail($departmentId);
        $this->name = $department->name;
    }

    public function render()
    {
        return view('livewire.department-edit');
    }

    public function submitForm(): void
    {
        $this->validate();
        Department::find($this->departmentId)->update(['name' => $this->name]);
        $this->dispatch('departmentSaved', __('Department successfully updated.'));
    }
}
