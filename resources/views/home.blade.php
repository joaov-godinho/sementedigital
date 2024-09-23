<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bem-vindo ao Semente Digital') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Texto explicatório sobre o projeto -->
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-3xl font-bold mb-6 dark:text-gray-300">Semente Digital</h1>
            <p class="text-lg text-gray-700 dark:text-gray-300 mb-10">
                O Semente Digital é uma plataforma voltada para pequenos agricultores, onde você pode gerenciar suas tarefas diárias, consultar a previsão do tempo e acompanhar o mercado agrícola. Tudo isso em um único lugar, com uma interface simples e amigável!
            </p>
        </div>

        <!-- Seção das caixas com imagens -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 gap-6 p-6">
                <!-- Caixa 1 -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    <img src="{{ asset('images/tarefas.jpg') }}" alt="Tarefas" class="object-cover w-full h-64">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Tarefas</h2>
                        <p class="text-gray-700 dark:text-gray-300">Gerencie suas tarefas diárias com facilidade.</p>
                        <a href="/tarefas" class="text-indigo-600 hover:text-indigo-800">Ver mais</a>
                    </div>
                </div>

                <!-- Caixa 2 -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    <img src="{{ asset('images/previsao.jpg') }}" alt="Previsão do Tempo" class="object-cover w-full h-64">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Previsão do Tempo</h2>
                        <p class="text-gray-700 dark:text-gray-300">Confira a previsão do tempo para sua região.</p>
                        <a href="/previsao-tempo" class="text-indigo-600 hover:text-indigo-800">Ver mais</a>
                    </div>
                </div>

                <!-- Caixa 3 -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    <img src="{{ asset('images/mercado.jpg') }}" alt="Mercado Agrícola" class="object-cover w-full h-64">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Mercado Agrícola</h2>
                        <p class="text-gray-700 dark:text-gray-300">Acompanhe os preços dos produtos agrícolas.</p>
                        <a href="/mercado" class="text-indigo-600 hover:text-indigo-800">Ver mais</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
