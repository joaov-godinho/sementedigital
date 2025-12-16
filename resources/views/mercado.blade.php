<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cotações Agropecuárias (Fonte: CEPEA/Esalq)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(isset($error))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p>{{ $error }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($commodities as $item)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ $item->name }}
                                </h3>
                                <div class="mt-2 flex items-baseline">
                                    <span class="text-3xl font-extrabold text-gray-900 dark:text-white">
                                        {{ $item->price }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $item->city }}
                            </div>
                            <div class="flex items-center mt-1 text-xs text-gray-400">
                                📅 Atualizado em: {{ $item->date }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center text-gray-500">
                        Nenhuma cotação encontrada no momento.
                    </div>
                @endforelse
            </div>
            
            <div class="mt-8 text-center text-xs text-gray-400">
                Os dados são obtidos publicamente do Centro de Estudos Avançados em Economia Aplicada (CEPEA-Esalq/USP) e possuem atraso de 1 dia útil.
            </div>

        </div>
    </div>
</x-app-layout>