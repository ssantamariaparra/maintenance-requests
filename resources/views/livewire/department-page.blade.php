<div>
    @if (session()->has('message'))
        <x-alert type="success">
            {{ session('message') }}
        </x-alert>
    @endif
    
    @if (session()->has('error'))
        <x-alert type="danger">
            {{ session('error') }}
        </x-alert>
    @endif

    <livewire:department-list />

    <flux:modal wire:model="creatingDepartment" class="md:max-w-lg">
        <div class="p-6">
            <livewire:department-create />
        </div>
    </flux:modal>

    @if($editingDepartment)
        <flux:modal wire:model="editingDepartment" class="md:max-w-lg">
            <div class="p-6">
                <livewire:department-edit :departmentId="$selectedDepartmentId" :key="$selectedDepartmentId" />
            </div>
        </flux:modal>
    @endif
</div>
