<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Previsão do Tempo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (isset($error))
                        <div class="alert alert-danger">{{ $error }}</div>
                    @else
                        <h3>Previsão do Tempo para os Próximos 3 Dias:</h3>
                            <ul>
                                @foreach ($weatherData as $forecast)
                                    <li>
                                        <strong>Data:</strong> {{ $forecast->date }}<br>
                                        <strong>Máx. Temperatura:</strong> {{ $forecast->maxtemp_c }}°C<br>
                                        <strong>Mín. Temperatura:</strong> {{ $forecast->mintemp_c }}°C<br>
                                        <strong>Temperatura Média:</strong> {{ $forecast->avgtemp_c }}°C<br>
                                        <strong>Velocidade Máxima do Vento:</strong> {{ $forecast->maxwind_kph }} km/h<br>
                                        <strong>Precipitação Total:</strong> {{ $forecast->totalprecip_mm }} mm<br>
                                        <strong>Umidade Média:</strong> {{ $forecast->avghumidity }}%<br>
                                        <strong>Chance de Chuva:</strong> {{ $forecast->daily_chance_of_rain }}%<br>
                                    <hr>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
