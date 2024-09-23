<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Previsão do Tempo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:text-gray-300 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (isset($error))
                    <div class="alert alert-danger mb-4 text-red-600">{{ $error }}</div>
                @else
                    <h3 class="text-lg font-bold mb-4">Previsão do Tempo para os Próximos 3 Dias:</h3>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                        @foreach ($weatherData as $forecast)
                            <li class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                                <strong class="block text-lg font-semibold">{{ $forecast->date }}</strong>
                                <div class="flex items-center mb-2">
                                    <img src="{{ $forecast->condition['icon'] }}" 
                                         alt="{{ $forecast->condition['text'] ?? 'Indisponível' }}" 
                                         class="w-16 h-16 mr-2"/>
                                    <span class="text-md font-medium">{{ $forecast->condition['text'] ?? 'Indisponível' }}</span>
                                </div>
                                <div class="text-sm">
                                    <p><strong>Máx. Temperatura:</strong> {{ $forecast->maxtemp_c }}°C</p>
                                    <p><strong>Mín. Temperatura:</strong> {{ $forecast->mintemp_c }}°C</p>
                                    <p><strong>Temperatura Média:</strong> {{ $forecast->avgtemp_c }}°C</p>
                                    <p><strong>Velocidade Máxima do Vento:</strong> {{ $forecast->maxwind_kph }} km/h</p>
                                    <p><strong>Precipitação Total:</strong> {{ $forecast->totalprecip_mm }} mm</p>
                                    <p><strong>Umidade Média:</strong> {{ $forecast->avghumidity }}%</p>
                                    <p><strong>Chance de Chuva:</strong> {{ $forecast->daily_chance_of_rain }}%</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
