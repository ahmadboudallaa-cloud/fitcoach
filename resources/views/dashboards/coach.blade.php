<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Coach
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-2">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-900">Planning</h3>
                    <p class="mt-2 text-sm text-gray-600">Voir les seances prevues.</p>
                    <a href="{{ route('coach.planning') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600">Ouvrir</a>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-900">Adherents</h3>
                    <p class="mt-2 text-sm text-gray-600">Consulter les fiches des adherents.</p>
                    <a href="{{ route('coach.adherents') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600">Ouvrir</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
