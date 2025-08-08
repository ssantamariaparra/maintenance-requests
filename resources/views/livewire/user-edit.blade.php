<form wire:submit.prevent="submitForm">
    <div>
        <flux:heading size="lg">{{ __('Edit User') }}</flux:heading>
        <flux:text class="mt-1">
            {{ __('Update the details for this user.') }}
        </flux:text>

        <div class="mt-6 space-y-6">
            <flux:input wire:model="name" :label="__('Name')" />
            <flux:input wire:model="email" type="email" :label="__('Email')" />
            <flux:input wire:model="password" type="password" :label="__('Password')"
                :hint="__('Leave blank to keep current password')" />

            <flux:select wire:model="role_id" :label="__('Role')">
                <option value="" disabled>{{ __('Select a role') }}</option>
                @foreach ($allRoles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </flux:select>

            <div>
                <flux:text as="label" class="text-sm font-medium">{{ __('Departments') }}</flux:text>
                <div class="mt-2 space-y-2">
                    @foreach ($allDepartments as $department)
                        <flux:checkbox wire:model="departments" value="{{ $department->id }}"
                            :label="$department->name" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div
        class="mt-6 flex justify-end gap-3 border-t border-zinc-200 bg-zinc-50 px-4 py-3 dark:border-zinc-700 dark:bg-zinc-800 sm:px-6">
        <flux:button wire:click.prevent="$dispatch('formCancelled')" variant="ghost">
            {{ __('Cancel') }}
        </flux:button>
        <flux:button type="submit" variant="primary">
            {{ __('Save Changes') }}
        </flux:button>
    </div>
</form>
