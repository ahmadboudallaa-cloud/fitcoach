<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Adherent
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-3">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-900">Reservation</h3>
                    <p class="mt-2 text-sm text-gray-600">Reserver une seance avec un coach.</p>
                    <a href="{{ route('adherent.reservation') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600">Ouvrir</a>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-900">Mes seances</h3>
                    <p class="mt-2 text-sm text-gray-600">Voir les seances a venir et passees.</p>
                    <a href="{{ route('adherent.seances') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600">Ouvrir</a>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-900">Programme</h3>
                    <p class="mt-2 text-sm text-gray-600">Consulter le programme donne par le coach.</p>
                    <a href="{{ route('adherent.programme') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600">Ouvrir</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
