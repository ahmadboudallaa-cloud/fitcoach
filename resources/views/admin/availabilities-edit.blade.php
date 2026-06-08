<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier une plage horaire
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.availabilities.update', $availability) }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="coach_id" value="Coach" />
                            <select id="coach_id" name="coach_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">Choisir un coach</option>
                                @foreach ($coachs as $coach)
                                    <option value="{{ $coach->id }}" @selected(old('coach_id', $availability->coach_id) == $coach->id)>
                                        {{ $coach->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('coach_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="available_date" value="Date" />
                            <x-text-input id="available_date" name="available_date" type="date" class="mt-1 block w-full" value="{{ old('available_date', $availability->available_date) }}" required />
                            <x-input-error :messages="$errors->get('available_date')" class="mt-2" />
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <x-input-label for="start_time" value="Heure debut" />
                                <x-text-input id="start_time" name="start_time" type="time" class="mt-1 block w-full" value="{{ old('start_time', substr($availability->start_time, 0, 5)) }}" required />
                                <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="end_time" value="Heure fin" />
                                <x-text-input id="end_time" name="end_time" type="time" class="mt-1 block w-full" value="{{ old('end_time', substr($availability->end_time, 0, 5)) }}" required />
                                <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                            </div>
                        </div>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_available" value="1" @checked(old('is_available', $availability->is_available)) class="rounded border-gray-300">
                            <span class="text-sm text-gray-700">Disponible</span>
                        </label>

                        <div class="flex items-center gap-3">
                            <x-primary-button>Modifier</x-primary-button>
                            <a href="{{ route('admin.availabilities') }}" class="text-sm text-gray-600">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
