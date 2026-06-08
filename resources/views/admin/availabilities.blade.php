<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Plages horaires
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Disponibilites des coachs</h3>
                        <a href="{{ route('admin.availabilities.create') }}">
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
                                    <th class="py-3">Coach</th>
                                    <th class="py-3">Date</th>
                                    <th class="py-3">Debut</th>
                                    <th class="py-3">Fin</th>
                                    <th class="py-3">Statut</th>
                                    <th class="py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($availabilities as $availability)
                                    <tr class="border-b">
                                        <td class="py-3">{{ $availability->coach?->name ?? '-' }}</td>
                                        <td class="py-3">{{ $availability->available_date }}</td>
                                        <td class="py-3">{{ substr($availability->start_time, 0, 5) }}</td>
                                        <td class="py-3">{{ substr($availability->end_time, 0, 5) }}</td>
                                        <td class="py-3">
                                            @if ($availability->is_available)
                                                <span class="text-green-600">Disponible</span>
                                            @else
                                                <span class="text-red-600">Indisponible</span>
                                            @endif
                                        </td>
                                        <td class="py-3">
                                            <div class="flex items-center gap-3">
                                                <a href="{{ route('admin.availabilities.edit', $availability) }}" class="text-indigo-600 font-semibold">Modifier</a>

                                                <form method="POST" action="{{ route('admin.availabilities.destroy', $availability) }}" onsubmit="return confirm('Supprimer cette plage horaire ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 font-semibold">Supprimer</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 text-gray-600">Aucune plage horaire ajoutee pour le moment.</td>
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
