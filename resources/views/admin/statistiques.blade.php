<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Statistiques
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-3">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Taux de remplissage</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">0%</p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Adherents actifs</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">0</p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Seances cette semaine</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">0</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
