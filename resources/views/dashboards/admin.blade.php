<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-4">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-900">Coachs</h3>
                    <p class="mt-2 text-sm text-gray-600">Ajouter ou modifier les coachs.</p>
                    <a href="{{ route('admin.coachs') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600">Ouvrir</a>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-900">Horaires</h3>
                    <p class="mt-2 text-sm text-gray-600">Definir les plages disponibles.</p>
                    <a href="{{ route('admin.availabilities') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600">Ouvrir</a>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-900">Seances</h3>
                    <p class="mt-2 text-sm text-gray-600">Voir toutes les seances de la salle.</p>
                    <a href="{{ route('admin.seances') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600">Ouvrir</a>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-900">Statistiques</h3>
                    <p class="mt-2 text-sm text-gray-600">Suivre les chiffres importants.</p>
                    <a href="{{ route('admin.statistiques') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600">Ouvrir</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
