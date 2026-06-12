<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Fiche adherent
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $adherent->name }}</h3>

                    <div class="mt-4 grid gap-4 md:grid-cols-2">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Email :</span>
                            {{ $adherent->email }}
                        </p>

                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Telephone :</span>
                            {{ $adherent->adherentProfile?->phone ?? '-' }}
                        </p>

                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Date de naissance :</span>
                            {{ $adherent->adherentProfile?->birth_date ?? '-' }}
                        </p>

                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Objectif :</span>
                            {{ $adherent->adherentProfile?->objective ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Seances avec cet adherent</h3>

                    <div class="mt-6 overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-gray-600 border-b">
                                <tr>
                                    <th class="py-3">Date</th>
                                    <th class="py-3">Heure</th>
                                    <th class="py-3">Statut</th>
                                    <th class="py-3">Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sessions as $session)
                                    <tr class="border-b">
                                        <td class="py-3">{{ $session->session_date }}</td>
                                        <td class="py-3">
                                            {{ substr($session->start_time, 0, 5) }}
                                            -
                                            {{ substr($session->end_time, 0, 5) }}
                                        </td>
                                        <td class="py-3">{{ $session->status }}</td>
                                        <td class="py-3">{{ $session->notes ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-gray-600">
                                            Aucune seance avec cet adherent.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('coach.adherents') }}" class="text-sm text-gray-600">Retour</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
