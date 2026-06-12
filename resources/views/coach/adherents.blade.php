<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes adherents
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Fiches adherents</h3>

                    <div class="mt-6 overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-gray-600 border-b">
                                <tr>
                                    <th class="py-3">Nom</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3">Telephone</th>
                                    <th class="py-3">Objectif</th>
                                    <th class="py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($adherents as $adherent)
                                    <tr class="border-b">
                                        <td class="py-3">{{ $adherent->name }}</td>
                                        <td class="py-3">{{ $adherent->email }}</td>
                                        <td class="py-3">{{ $adherent->adherentProfile?->phone ?? '-' }}</td>
                                        <td class="py-3">{{ $adherent->adherentProfile?->objective ?? '-' }}</td>
                                        <td class="py-3">
                                            <a href="{{ route('coach.adherents.show', $adherent) }}" class="text-indigo-600 font-semibold">
                                                Voir fiche
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 text-gray-600">
                                            Aucun adherent affecte pour le moment.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
