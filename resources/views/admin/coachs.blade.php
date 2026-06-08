<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion des coachs
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Coachs</h3>
                        <x-primary-button>Ajouter</x-primary-button>
                    </div>

                    <p class="mt-4 text-gray-600">Aucun coach ajoute pour le moment.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
