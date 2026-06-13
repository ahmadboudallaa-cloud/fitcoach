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
                    <h3 class="text-lg font-semibold text-gray-900">Ajouter un programme d'entrainement</h3>

                    <form method="POST" action="{{ route('coach.adherents.programs.store', $adherent) }}" class="mt-6 space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="title" value="Titre du programme" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title') }}" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" value="Description" />
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <x-input-label for="start_date" value="Date debut" />
                                <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" value="{{ old('start_date') }}" />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="end_date" value="Date fin" />
                                <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" value="{{ old('end_date') }}" />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>
                        </div>

                        <div class="rounded-md border border-gray-200 p-4">
                            <h4 class="font-semibold text-gray-900">Premier exercice</h4>

                            <div class="mt-4">
                                <x-input-label for="exercise_name" value="Nom de l'exercice" />
                                <x-text-input id="exercise_name" name="exercise_name" type="text" class="mt-1 block w-full" value="{{ old('exercise_name') }}" />
                                <x-input-error :messages="$errors->get('exercise_name')" class="mt-2" />
                            </div>

                            <div class="mt-4 grid gap-4 md:grid-cols-2">
                                <div>
                                    <x-input-label for="sets" value="Series" />
                                    <x-text-input id="sets" name="sets" type="number" class="mt-1 block w-full" value="{{ old('sets') }}" />
                                    <x-input-error :messages="$errors->get('sets')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="reps" value="Repetitions" />
                                    <x-text-input id="reps" name="reps" type="number" class="mt-1 block w-full" value="{{ old('reps') }}" />
                                    <x-input-error :messages="$errors->get('reps')" class="mt-2" />
                                </div>
                            </div>

                            <div class="mt-4">
                                <x-input-label for="exercise_notes" value="Notes exercice" />
                                <textarea id="exercise_notes" name="exercise_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('exercise_notes') }}</textarea>
                                <x-input-error :messages="$errors->get('exercise_notes')" class="mt-2" />
                            </div>
                        </div>

                        <x-primary-button>Ajouter le programme</x-primary-button>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Programmes d'entrainement</h3>

                    <div class="mt-6 space-y-4">
                        @forelse ($programs as $program)
                            <div class="rounded-md border border-gray-200 p-4">
                                <h4 class="font-semibold text-gray-900">{{ $program->title }}</h4>
                                <p class="mt-2 text-sm text-gray-600">{{ $program->description ?? '-' }}</p>
                                <p class="mt-2 text-sm text-gray-600">
                                    Du {{ $program->start_date ?? '-' }} au {{ $program->end_date ?? '-' }}
                                </p>

                                <div class="mt-4">
                                    <p class="font-semibold text-sm text-gray-900">Exercices</p>

                                    @forelse ($program->exercises as $exercise)
                                        <p class="mt-2 text-sm text-gray-700">
                                            {{ $exercise->name }}
                                            -
                                            {{ $exercise->sets ?? '-' }} series
                                            x
                                            {{ $exercise->reps ?? '-' }} reps
                                            @if ($exercise->notes)
                                                - {{ $exercise->notes }}
                                            @endif
                                        </p>
                                    @empty
                                        <p class="mt-2 text-sm text-gray-600">Aucun exercice ajoute.</p>
                                    @endforelse
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-600">Aucun programme ajoute.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Ajouter un objectif et une progression</h3>

                    <form method="POST" action="{{ route('coach.adherents.goals.store', $adherent) }}" class="mt-6 space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="goal" value="Objectif" />
                            <x-text-input id="goal" name="goal" type="text" class="mt-1 block w-full" value="{{ old('goal') }}" required />
                            <x-input-error :messages="$errors->get('goal')" class="mt-2" />
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <x-input-label for="progress" value="Progression" />
                                <x-text-input id="progress" name="progress" type="number" min="0" max="100" class="mt-1 block w-full" value="{{ old('progress', 0) }}" required />
                                <x-input-error :messages="$errors->get('progress')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="progress_date" value="Date" />
                                <x-text-input id="progress_date" name="progress_date" type="date" class="mt-1 block w-full" value="{{ old('progress_date', now()->toDateString()) }}" required />
                                <x-input-error :messages="$errors->get('progress_date')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="goal_notes" value="Notes" />
                            <textarea id="goal_notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <x-primary-button>Ajouter l'objectif</x-primary-button>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Objectifs et progression</h3>

                    <div class="mt-6 overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-gray-600 border-b">
                                <tr>
                                    <th class="py-3">Date</th>
                                    <th class="py-3">Objectif</th>
                                    <th class="py-3">Progression</th>
                                    <th class="py-3">Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($goals as $goal)
                                    <tr class="border-b">
                                        <td class="py-3">{{ $goal->progress_date }}</td>
                                        <td class="py-3">{{ $goal->goal }}</td>
                                        <td class="py-3">
                                            <div class="flex items-center gap-3">
                                                <div class="h-2 w-32 rounded bg-gray-200">
                                                    <div class="h-2 rounded bg-indigo-600" style="width: {{ $goal->progress }}%"></div>
                                                </div>
                                                <span>{{ $goal->progress }}%</span>
                                            </div>
                                        </td>
                                        <td class="py-3">{{ $goal->notes ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-gray-600">
                                            Aucun objectif ajoute.
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
