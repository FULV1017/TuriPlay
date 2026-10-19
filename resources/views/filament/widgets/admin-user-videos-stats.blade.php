<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Estadísticas por usuario
        </x-slot>

        {{ $this->form }}

        <div class="mt-6 grid gap-4 sm:grid-cols-3">
            @foreach ($this->metrics() as $metric)
                <div class="rounded-xl bg-gray-50 p-4 ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $metric['label'] }}
                    </div>

                    <div class="mt-1 text-2xl font-semibold text-gray-950 dark:text-white">
                        {{ $metric['value'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
