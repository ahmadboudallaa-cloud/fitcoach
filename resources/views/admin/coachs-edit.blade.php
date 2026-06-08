<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier un coach
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.coachs.update', $coach) }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" value="Nom" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $coach->name) }}" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $coach->email) }}" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" value="Nouveau mot de passe" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                            <p class="mt-1 text-sm text-gray-500">Laisser vide pour garder le mot de passe actuel.</p>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="specialty" value="Specialite" />
                            <x-text-input id="specialty" name="specialty" type="text" class="mt-1 block w-full" value="{{ old('specialty', $coach->coachProfile?->specialty) }}" />
                            <x-input-error :messages="$errors->get('specialty')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="phone" value="Telephone" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" value="{{ old('phone', $coach->coachProfile?->phone) }}" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="bio" value="Bio" />
                            <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('bio', $coach->coachProfile?->bio) }}</textarea>
                            <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                        </div>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $coach->coachProfile?->is_active)) class="rounded border-gray-300">
                            <span class="text-sm text-gray-700">Coach actif</span>
                        </label>

                        <div class="flex items-center gap-3">
                            <x-primary-button>Modifier</x-primary-button>
                            <a href="{{ route('admin.coachs') }}" class="text-sm text-gray-600">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
