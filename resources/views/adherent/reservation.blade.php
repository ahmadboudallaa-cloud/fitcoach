<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reserver une seance
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Nouvelle reservation</h3>

                    <form method="POST" action="{{ route('adherent.reservation.store') }}" class="mt-6 space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="availability_id" value="Plage disponible" />
                            <select id="availability_id" name="availability_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">Choisir une plage horaire</option>
                                @foreach ($availabilities as $availability)
                                    <option value="{{ $availability->id }}" @selected(old('availability_id') == $availability->id)>
                                        {{ $availability->coach?->name }}
                                        -
                                        {{ $availability->coach?->coachProfile?->specialty ?? 'Sans specialite' }}
                                        -
                                        {{ $availability->available_date }}
                                        de {{ substr($availability->start_time, 0, 5) }}
                                        a {{ substr($availability->end_time, 0, 5) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('availability_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="notes" value="Notes" />
                            <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        @if ($availabilities->isEmpty())
                            <p class="text-sm text-gray-600">Aucune plage horaire disponible pour le moment.</p>
                        @endif

                        <x-primary-button @disabled($availabilities->isEmpty())>
                            Reserver
                        </x-primary-button>
                    </form>

                    <div class="mt-10">
                        <h3 class="text-lg font-semibold text-gray-900">Creneaux disponibles</h3>

                        <div class="mt-4 overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-gray-600 border-b">
                                    <tr>
                                        <th class="py-3">Coach</th>
                                        <th class="py-3">Specialite</th>
                                        <th class="py-3">Date</th>
                                        <th class="py-3">Debut</th>
                                        <th class="py-3">Fin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($availabilities as $availability)
                                        <tr class="border-b">
                                            <td class="py-3">{{ $availability->coach?->name ?? '-' }}</td>
                                            <td class="py-3">{{ $availability->coach?->coachProfile?->specialty ?? '-' }}</td>
                                            <td class="py-3">{{ $availability->available_date }}</td>
                                            <td class="py-3">{{ substr($availability->start_time, 0, 5) }}</td>
                                            <td class="py-3">{{ substr($availability->end_time, 0, 5) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-4 text-gray-600">
                                                Aucun creneau disponible pour le moment.
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
    </div>
</x-app-layout>
