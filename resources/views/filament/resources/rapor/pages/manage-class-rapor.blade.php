<x-filament-panels::page>
    {{-- Semester Selector --}}
    <div class="flex items-center gap-3 mb-4">
        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Semester:</span>
        <div class="inline-flex rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <button
                wire:click="setSemester('1')"
                class="px-4 py-2 text-sm font-medium transition-colors duration-150
                    {{ $semester === '1'
                        ? 'bg-primary-600 text-white shadow-sm'
                        : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}"
            >
                Semester 1 (Ganjil)
            </button>
            <button
                wire:click="setSemester('2')"
                class="px-4 py-2 text-sm font-medium transition-colors duration-150 border-l border-gray-200 dark:border-gray-700
                    {{ $semester === '2'
                        ? 'bg-primary-600 text-white shadow-sm'
                        : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}"
            >
                Semester 2 (Genap)
            </button>
        </div>
    </div>

    {{-- Student Table --}}
    <div class="fi-resource-manage-class-rapor">
        {{ $this->table }}
    </div>
</x-filament-panels::page>
