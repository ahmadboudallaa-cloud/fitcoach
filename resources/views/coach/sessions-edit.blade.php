<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier une seance
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-sm text-gray-600">
                        Adherent : {{ $session->adherent?->name ?? '-' }}
                    </p>

                    <form method="POST" action="{{ route('coach.sessions.update', $session) }}" class="mt-6 space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="session_date" value="Date" />
                            <x-text-input id="session_date" name="session_date" type="date" class="mt-1 block w-full" value="{{ old('session_date', $session->session_date) }}" required />
                            <x-input-error :messages="$errors->get('session_date')" class="mt-2" />
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <x-input-label for="start_time" value="Heure debut" />
                                <x-text-input id="start_time" name="start_time" type="time" class="mt-1 block w-full" value="{{ old('start_time', substr($session->start_time, 0, 5)) }}" required />
                                <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="end_time" value="Heure fin" />
                                <x-text-input id="end_time" name="end_time" type="time" class="mt-1 block w-full" value="{{ old('end_time', substr($session->end_time, 0, 5)) }}" required />
                                <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="status" value="Statut" />
                            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="pending" @selected(old('status', $session->status) === 'pending')>En attente</option>
                                <option value="confirmed" @selected(old('status', $session->status) === 'confirmed')>Confirmee</option>
                                <option value="cancelled" @selected(old('status', $session->status) === 'cancelled')>Annulee</option>
                                <option value="completed" @selected(old('status', $session->status) === 'completed')>Terminee</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="notes" value="Notes" />
                            <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes', $session->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-3">
                            <x-primary-button>Modifier</x-primary-button>
                            <a href="{{ route('coach.planning') }}" class="text-sm text-gray-600">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
