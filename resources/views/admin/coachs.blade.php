<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion des coachs
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Coachs</h3>
                        <a href="{{ route('admin.coachs.create') }}">
                            <x-primary-button>Ajouter</x-primary-button>
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mt-4 rounded-md bg-green-100 p-4 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mt-6 overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-gray-600 border-b">
                                <tr>
                                    <th class="py-3">Nom</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3">Specialite</th>
                                    <th class="py-3">Telephone</th>
                                    <th class="py-3">Statut</th>
                                    <th class="py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($coachs as $coach)
                                    <tr class="border-b">
                                        <td class="py-3">{{ $coach->name }}</td>
                                        <td class="py-3">{{ $coach->email }}</td>
                                        <td class="py-3">{{ $coach->coachProfile?->specialty ?? '-' }}</td>
                                        <td class="py-3">{{ $coach->coachProfile?->phone ?? '-' }}</td>
                                        <td class="py-3">
                                            @if ($coach->coachProfile?->is_active)
                                                <span class="text-green-600">Actif</span>
                                            @else
                                                <span class="text-red-600">Inactif</span>
                                            @endif
                                        </td>
                                        <td class="py-3">
                                            <div class="flex items-center gap-3">
                                                <a href="{{ route('admin.coachs.edit', $coach) }}" class="text-indigo-600 font-semibold">Modifier</a>

                                                <form method="POST" action="{{ route('admin.coachs.destroy', $coach) }}" onsubmit="return confirm('Supprimer ce coach ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 font-semibold">Supprimer</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 text-gray-600">Aucun coach ajoute pour le moment.</td>
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
