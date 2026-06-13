<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-4">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-900">Coachs</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalCoachs }}</p>
                    <a href="{{ route('admin.coachs') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600">Ouvrir</a>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-900">Horaires</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalAvailabilities }}</p>
                    <a href="{{ route('admin.availabilities') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600">Ouvrir</a>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-900">Seances</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalSessions }}</p>
                    <a href="{{ route('admin.seances') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600">Ouvrir</a>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-900">Adherents</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalAdherents }}</p>
                    <a href="{{ route('admin.statistiques') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600">Ouvrir</a>
                </div>
            </div>

            <div class="mt-6 grid gap-6 lg:grid-cols-2">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-900">Vue generale</h3>
                    <div class="mt-6">
                        <canvas id="overviewChart" height="140"></canvas>
                    </div>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-900">Statut des seances</h3>
                    <div class="mt-6">
                        <canvas id="sessionsStatusChart" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const overviewCanvas = document.getElementById('overviewChart');
            const sessionsStatusCanvas = document.getElementById('sessionsStatusChart');

            new Chart(overviewCanvas, {
                type: 'bar',
                data: {
                    labels: ['Adherents', 'Coachs', 'Seances', 'Horaires'],
                    datasets: [{
                        label: 'Total',
                        data: [
                            {{ $totalAdherents }},
                            {{ $totalCoachs }},
                            {{ $totalSessions }},
                            {{ $totalAvailabilities }},
                        ],
                        backgroundColor: ['#4f46e5', '#059669', '#f59e0b', '#2563eb'],
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

            new Chart(sessionsStatusCanvas, {
                type: 'doughnut',
                data: {
                    labels: ['En attente', 'Confirmees', 'Annulees'],
                    datasets: [{
                        data: [
                            {{ $pendingSessions }},
                            {{ $confirmedSessions }},
                            {{ $cancelledSessions }},
                        ],
                        backgroundColor: ['#f59e0b', '#059669', '#dc2626'],
                    }],
                },
                options: {
                    responsive: true,
                },
            });
        </script>
    @endpush
</x-app-layout>
