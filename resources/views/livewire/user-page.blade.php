<div>
    @if (session()->has('message'))
        <x-alert type="success">
            {{ session('message') }}
        </x-alert>
    @endif

    <livewire:user-list />

    <flux:modal wire:model="creatingUser" class="md:w-full md:max-w-2xl">
        <livewire:user-create />
    </flux:modal>

    @if ($editingUser)
        <flux:modal wire:model="editingUser" class="md:w-full md:max-w-2xl">
            <livewire:user-edit :userId="$selectedUserId" :key="$selectedUserId" />
        </flux:modal>
    @endif

</div>
