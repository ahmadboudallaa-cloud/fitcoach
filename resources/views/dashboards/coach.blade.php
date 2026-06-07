<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Coach
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Bienvenue coach {{ Auth::user()->name }}.
                    <br>
                    Ici, le coach pourra gerer son planning et ses adherents.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
