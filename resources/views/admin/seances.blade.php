<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Toutes les seances
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Suivi des seances</h3>

                    <div class="mt-6 overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-gray-600 border-b">
                                <tr>
                                    <th class="py-3">Adherent</th>
                                    <th class="py-3">Coach</th>
                                    <th class="py-3">Date</th>
                                    <th class="py-3">Debut</th>
                                    <th class="py-3">Fin</th>
                                    <th class="py-3">Statut</th>
                                    <th class="py-3">Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sessions as $session)
                                    <tr class="border-b">
                                        <td class="py-3">{{ $session->adherent?->name ?? '-' }}</td>
                                        <td class="py-3">{{ $session->coach?->name ?? '-' }}</td>
                                        <td class="py-3">{{ $session->session_date }}</td>
                                        <td class="py-3">{{ substr($session->start_time, 0, 5) }}</td>
                                        <td class="py-3">{{ substr($session->end_time, 0, 5) }}</td>
                                        <td class="py-3">
                                            @if ($session->status === 'pending')
                                                <span class="text-yellow-600">En attente</span>
                                            @elseif ($session->status === 'confirmed')
                                                <span class="text-green-600">Confirmee</span>
                                            @elseif ($session->status === 'cancelled')
                                                <span class="text-red-600">Annulee</span>
                                            @elseif ($session->status === 'completed')
                                                <span class="text-blue-600">Terminee</span>
                                            @else
                                                {{ $session->status }}
                                            @endif
                                        </td>
                                        <td class="py-3">{{ $session->notes ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-4 text-gray-600">Aucune seance enregistree.</td>
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
