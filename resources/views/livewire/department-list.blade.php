<div class="overflow-hidden rounded-lg bg-white shadow dark:bg-zinc-900" x-data="{ filtersOpen: false }">
    <div class="px-4 py-5 sm:p-6">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h3 class="text-base font-semibold leading-6 text-zinc-900 dark:text-white">
                    {{ __('Departments') }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-zinc-500 dark:text-zinc-400">
                    {{ __('A list of all the hotel departments.') }}
                </p>
            </div>
            <div>
                <flux:button wire:click="$dispatch('createDepartment')" :label="__('Add department')" icon="plus" />
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
        <div class="hidden lg:grid" :class="{ '!grid': filtersOpen }" x-cloak>
            <div class="mt-4 grid grid-cols-1 gap-4 border-b border-zinc-200 pb-5 dark:border-zinc-700 sm:grid-cols-2 items-end">
                <flux:input wire:model.live.debounce.300ms="searchName" :label="__('Filter by Name')" placeholder="{{ __('e.g. Housekeeping') }}" />
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
                        <th scope="col" class="px-6 py-3 w-px text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">{{ __('Users') }}</th>
                        <th scope="col" class="relative px-6 py-3 w-px"><span class="sr-only">{{ __('Actions') }}</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-800 dark:bg-zinc-900">
                    @forelse ($departments as $department)
                        <tr wire:key="department-{{ $department->id }}">
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-zinc-900 dark:text-white">{{ $department->name }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-500">
                                <flux:badge :color="$department->users_count > 0 ? 'sky' : 'zinc'">
                                    {{ $department->users_count }}
                                </flux:badge>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                <flux:dropdown>
                                    <flux:button variant="ghost" icon="ellipsis-vertical" />
                                    <flux:menu>
                                        <flux:menu.item wire:click="$dispatch('editDepartment', { departmentId: {{ $department->id }} })" icon="pencil-square">{{ __('Edit') }}</flux:menu.item>
                                        <flux:menu.separator />
                                        <flux:menu.item wire:click="confirmDelete({{ $department->id }})" icon="trash" variant="danger">{{ __('Delete') }}</flux:menu.item>
                                    </flux:menu>
                                </flux:dropdown>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="mx-auto max-w-sm">
                                    <flux:icon name="building-office-2" class="mx-auto h-12 w-12 text-zinc-400" />
                                    <h3 class="mt-2 text-sm font-semibold text-zinc-900 dark:text-white">{{ __('No departments found') }}</h3>
                                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('There are no departments to display yet.') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($departments->hasPages())
        <div class="border-t border-zinc-200 bg-white px-4 py-3 dark:border-zinc-700 dark:bg-zinc-900 sm:px-6">
            {{ $departments->links() }}
        </div>
    @endif

    <flux:modal wire:model="showDeleteModal" class="md:max-w-md">
        <div class="p-6">
            <div class="flex items-start gap-4">
                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/50 sm:mx-0 sm:h-10 sm:w-10">
                    <flux:icon name="exclamation-triangle" class="h-6 w-6 text-red-600 dark:text-red-400" />
                </div>
                <div class="flex-1">
                    <flux:heading size="lg">{{ __('Delete Department') }}</flux:heading>
                    <flux:text class="mt-2">{{ __('Are you sure you want to delete this department? This action cannot be undone.') }}</flux:text>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <flux:button wire:click="$set('showDeleteModal', false)">{{ __('Cancel') }}</flux:button>
                <flux:button variant="danger" wire:click="deleteDepartment">{{ __('Delete Department') }}</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
