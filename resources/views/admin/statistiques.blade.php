<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Statistiques
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-3">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Taux de remplissage</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $fillRate }}%</p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Adherents actifs</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalAdherents }}</p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Seances cette semaine</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $sessionsThisWeek }}</p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Coachs</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalCoachs }}</p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total seances</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalSessions }}</p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Plages horaires</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalAvailabilities }}</p>
                </div>
            </div>

            <div class="mt-6 bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900">Statut des seances</h3>

                <div class="mt-6 grid gap-4 md:grid-cols-4">
                    <div class="rounded-md border border-gray-200 p-4">
                        <p class="text-sm text-gray-500">En attente</p>
                        <p class="mt-2 text-2xl font-bold text-yellow-600">{{ $pendingSessions }}</p>
                    </div>

                    <div class="rounded-md border border-gray-200 p-4">
                        <p class="text-sm text-gray-500">Confirmees</p>
                        <p class="mt-2 text-2xl font-bold text-green-600">{{ $confirmedSessions }}</p>
                    </div>

                    <div class="rounded-md border border-gray-200 p-4">
                        <p class="text-sm text-gray-500">Annulees</p>
                        <p class="mt-2 text-2xl font-bold text-red-600">{{ $cancelledSessions }}</p>
                    </div>

                    <div class="rounded-md border border-gray-200 p-4">
                        <p class="text-sm text-gray-500">Terminees</p>
                        <p class="mt-2 text-2xl font-bold text-blue-600">{{ $completedSessions }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900">Graphique des seances</h3>

                <div class="mt-6">
                    <canvas id="statisticsChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            new Chart(document.getElementById('statisticsChart'), {
                type: 'bar',
                data: {
                    labels: ['En attente', 'Confirmees', 'Annulees', 'Terminees'],
                    datasets: [{
                        label: 'Seances',
                        data: [
                            {{ $pendingSessions }},
                            {{ $confirmedSessions }},
                            {{ $cancelledSessions }},
                            {{ $completedSessions }},
                        ],
                        backgroundColor: ['#f59e0b', '#059669', '#dc2626', '#2563eb'],
                    }],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                            },
                        },
                    },
                },
            });
        </script>
    @endpush
</x-app-layout>
