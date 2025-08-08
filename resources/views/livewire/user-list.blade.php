<div class="overflow-hidden rounded-lg bg-white shadow dark:bg-zinc-900" x-data="{ filtersOpen: false }">
    <div class="px-4 py-5 sm:p-6">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h3 class="text-base font-semibold leading-6 text-zinc-900 dark:text-white">
                    {{ __('Users') }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-zinc-500 dark:text-zinc-400">
                    {{ __('A list of all the users in your hotel including their name, role, and email.') }}
                </p>
            </div>
            <div>
                <flux:button wire:click="$dispatch('createUser')" :label="__('Add user')" icon="plus" />
            </div>
        </div>

        {{-- Mobile Filters Toggle Button --}}
        <div class="mt-4 border-b border-zinc-200 pb-4 dark:border-zinc-700 lg:hidden">
            <flux:button
                variant="subtle"
                class="w-full"
                @click="filtersOpen = !filtersOpen"
                icon-right="adjustments-horizontal"
            >
                <span x-show="!filtersOpen">{{ __('Show Filters') }}</span>
                <span x-show="filtersOpen" x-cloak>{{ __('Hide Filters') }}</span>
            </flux:button>
        </div>

        {{-- Filters Section --}}
        <div
            class="hidden lg:grid"
            :class="{ '!grid': filtersOpen }"
            x-cloak
        >
            <div class="mt-4 grid grid-cols-1 gap-4 border-b border-zinc-200 pb-5 dark:border-zinc-700 sm:grid-cols-2 lg:grid-cols-5 items-end">
                <flux:input wire:model.live.debounce.300ms="searchName" :label="__('Filter by Name')" placeholder="{{ __('John Doe') }}" />
                <flux:input wire:model.live.debounce.300ms="searchEmail" type="email" :label="__('Filter by Email')" placeholder="{{ __('john@example.com') }}" />
                <flux:select wire:model.live="searchRoleId" :label="__('Filter by Role')">
                    <option value="">{{ __('All Roles') }}</option>
                    @foreach($allRoles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </flux:select>
                <flux:select wire:model.live="searchDepartmentId" :label="__('Filter by Department')">
                    <option value="">{{ __('All Departments') }}</option>
                    @foreach($allDepartments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </flux:select>
                <div>
                    <label class="block text-sm font-medium">&nbsp;</label> {{-- Spacer for alignment --}}
                    <flux:button wire:click="clearFilters" variant="ghost" class="w-full">
                        {{ __('Clear Filters') }}
                    </flux:button>
                </div>
            </div>
        </div>


        <div class="mt-5 overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">{{ __('Name') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">{{ __('Email') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">{{ __('Role') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">{{ __('Departments') }}</th>
                        <th scope="col" class="relative px-6 py-3 w-px"><span class="sr-only">{{ __('Actions') }}</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-800 dark:bg-zinc-900">
                    @forelse ($users as $user)
                        <tr wire:key="user-{{ $user->id }}">
                            <td class="whitespace-nowrap px-6 py-4">
                                <button wire:click="$dispatch('editUser', { userId: {{ $user->id }} })" class="w-full text-left">{{ $user->name }}</button>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <button wire:click="$dispatch('editUser', { userId: {{ $user->id }} })" class="text-sm text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">
                                    {{ $user->email }}
                                </button>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <flux:badge :color="$user->role->id === 1 ? 'sky' : 'zinc'">{{ __($user->role->name) }}</flux:badge>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($user->departments as $department)
                                        <flux:badge color="emerald">{{ __($department->name) }}</flux:badge>
                                    @endforeach
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                <flux:dropdown>
                                    <flux:button variant="ghost" icon="ellipsis-vertical" />
                                    <flux:menu>
                                        <flux:menu.item wire:click="$dispatch('editUser', { userId: {{ $user->id }} })" icon="pencil-square">{{ __('Edit') }}</flux:menu.item>
                                        <flux:menu.separator />
                                        <flux:menu.item wire:click="confirmDelete({{ $user->id }})" icon="trash" variant="danger">{{ __('Delete') }}</flux:menu.item>
                                    </flux:menu>
                                </flux:dropdown>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-3 text-center">
                                <div class="mx-auto max-w-sm">
                                    <h3 class="mt-2 text-sm font-semibold text-zinc-900 dark:text-white">{{ __('No users found') }}</h3>
                                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('There are no users to display yet.') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
        <div class="border-t border-zinc-200 bg-white px-4 py-3 dark:border-zinc-700 dark:bg-zinc-900 sm:px-6">
            {{ $users->links() }}
        </div>
    @endif

    <flux:modal wire:model="showDeleteModal" class="md:max-w-md">
        <div class="p-6">
            <div class="flex items-start gap-4">
                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/50 sm:mx-0 sm:h-10 sm:w-10">
                    <flux:icon name="exclamation-triangle" class="h-6 w-6 text-red-600 dark:text-red-400" />
                </div>
                <div class="flex-1">
                    <flux:heading size="lg">{{ __('Delete User') }}</flux:heading>
                    <flux:text class="mt-2">{{ __('Are you sure you want to delete this user? This action cannot be undone.') }}</flux:text>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <flux:button wire:click="$set('showDeleteModal', false)">{{ __('Cancel') }}</flux:button>
                <flux:button variant="danger" wire:click="deleteUser">{{ __('Delete User') }}</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
