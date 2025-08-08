<form wire:submit.prevent="submitForm">
    <flux:heading size="lg">{{ __('Create Department') }}</flux:heading>
    <flux:text class="mt-1">{{ __('Enter the name for the new department.') }}</flux:text>
    <div class="mt-6">
        <flux:input wire:model="name" :label="__('Department Name')" />
    </div>
    <div class="mt-6 flex justify-end gap-3">
        <flux:button wire:click.prevent="$dispatch('formCancelled')" variant="ghost">{{ __('Cancel') }}</flux:button>
        <flux:button type="submit" variant="primary">{{ __('Create Department') }}</flux:button>
    </div>
</form>
