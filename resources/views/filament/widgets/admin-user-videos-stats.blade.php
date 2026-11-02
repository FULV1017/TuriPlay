<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">Estadísticas por usuario</x-slot>
        <x-slot name="description">Consulta los videos y el espacio utilizado por cada cuenta.</x-slot>

        {{ $this->form }}

        <dl class="tp-user-metrics" aria-live="polite" aria-atomic="true">
            @foreach ($this->metrics() as $metric)
                <div class="tp-user-metric">
                    <dt>{{ $metric['label'] }}</dt>
                    <dd>{{ $metric['value'] }}</dd>
                </div>
            @endforeach
        </dl>
    </x-filament::section>
</x-filament-widgets::widget>
