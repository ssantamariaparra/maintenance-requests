@props([
    'type' => 'success', // Default type is 'success'
])

@php
    $baseClasses = 'rounded-md p-4 mb-4';
    $typeClasses = [
        'success' => 'bg-green-100 dark:bg-green-900/50 border border-green-200 dark:border-green-800',
        'danger' => 'bg-red-100 dark:bg-red-900/50 border border-red-200 dark:border-red-800',
        'warning' => 'bg-yellow-100 dark:bg-yellow-900/50 border border-yellow-200 dark:border-yellow-800',
        'info' => 'bg-blue-100 dark:bg-blue-900/50 border border-blue-200 dark:border-blue-800',
    ];

    $iconClasses = [
        'success' => 'text-green-500 dark:text-green-400',
        'danger' => 'text-red-500 dark:text-red-400',
        'warning' => 'text-yellow-500 dark:text-yellow-400',
        'info' => 'text-blue-500 dark:text-blue-400',
    ];

    $textClasses = [
        'success' => 'text-green-800 dark:text-green-200',
        'danger' => 'text-red-800 dark:text-red-200',
        'warning' => 'text-yellow-800 dark:text-yellow-200',
        'info' => 'text-blue-800 dark:text-blue-200',
    ];

    // Map alert types to Heroicon names for the flux:icon component
    $iconNames = [
        'success' => 'check-circle',
        'danger' => 'x-circle',
        'warning' => 'exclamation-triangle',
        'info' => 'information-circle',
    ];

@endphp

<div {{ $attributes->merge(['class' => $baseClasses . ' ' . ($typeClasses[$type] ?? $typeClasses['info'])]) }}>
    <div class="flex">
        <div class="flex-shrink-0">
            <flux:icon 
                :name="$iconNames[$type] ?? $iconNames['info']" 
                class="h-5 w-5 {{ $iconClasses[$type] ?? $iconClasses['info'] }}"
                aria-hidden="true" 
            />
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium {{ $textClasses[$type] ?? $textClasses['info'] }}">
                {{ $slot }}
            </p>
        </div>
    </div>
</div>
