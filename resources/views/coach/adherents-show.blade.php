<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Fiche adherent
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="rounded-md bg-green-100 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

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
                    <h3 class="text-lg font-semibold text-gray-900">Ajouter un bilan physique</h3>

                    <form method="POST" action="{{ route('coach.adherents.assessments.store', $adherent) }}" class="mt-6 space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="assessment_date" value="Date du bilan" />
                            <x-text-input id="assessment_date" name="assessment_date" type="date" class="mt-1 block w-full" value="{{ old('assessment_date', now()->toDateString()) }}" required />
                            <x-input-error :messages="$errors->get('assessment_date')" class="mt-2" />
                        </div>

                        <div class="grid gap-4 md:grid-cols-3">
                            <div>
                                <x-input-label for="weight" value="Poids" />
                                <x-text-input id="weight" name="weight" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('weight') }}" />
                                <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="height" value="Taille" />
                                <x-text-input id="height" name="height" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('height') }}" />
                                <x-input-error :messages="$errors->get('height')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="body_fat" value="Masse grasse" />
                                <x-text-input id="body_fat" name="body_fat" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('body_fat') }}" />
                                <x-input-error :messages="$errors->get('body_fat')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="notes" value="Notes" />
                            <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <x-primary-button>Ajouter le bilan</x-primary-button>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Bilans physiques</h3>

                    <div class="mt-6 overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-gray-600 border-b">
                                <tr>
                                    <th class="py-3">Date</th>
                                    <th class="py-3">Poids</th>
                                    <th class="py-3">Taille</th>
                                    <th class="py-3">Masse grasse</th>
                                    <th class="py-3">Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($assessments as $assessment)
                                    <tr class="border-b">
                                        <td class="py-3">{{ $assessment->assessment_date }}</td>
                                        <td class="py-3">{{ $assessment->weight ?? '-' }}</td>
                                        <td class="py-3">{{ $assessment->height ?? '-' }}</td>
                                        <td class="py-3">{{ $assessment->body_fat ?? '-' }}</td>
                                        <td class="py-3">{{ $assessment->notes ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 text-gray-600">
                                            Aucun bilan physique ajoute.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
