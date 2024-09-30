<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contato') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl max-h-10x1 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 h-100">
                <h1 class="text-center text-2xl font-bold mb-4 dark:text-gray-300">Entre em contato conosco</h1>
                @if (session('success'))
                    <div class="bg-green-500 text-white p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('contato.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nome" class="block dark:text-gray-300">Nome:</label>
                        <input type= "text" name="nome" id="nome" class="dark:text-gray-800 w-full  border-gray-800 rounded-lg" value="{{ old('nome') }}" required>
                        @error('nome') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block dark:text-gray-300">Email:</label>
                        <input type="email" name="email" id="email" class="w-full dark:text-gray-800 border-gray-800 rounded-lg" value="{{ old('email') }}" required>
                        @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="mensagem" class="block dark:text-gray-300">Mensagem:</label>
                        <textarea name="mensagem" id="mensagem" class="w-full dark:text-gray-800 border-gray-800 rounded-lg" required>{{ old('mensagem') }}</textarea>
                        @error('mensagem') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="bg-blue-500 text-white p-3 rounded">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
