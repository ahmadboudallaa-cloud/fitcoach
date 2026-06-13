<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes seances
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Liste des seances</h3>

                    @if (session('success'))
                        <div class="mt-4 rounded-md bg-green-100 p-4 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mt-6 rounded-md border border-gray-200 p-4">
                        <div class="flex items-center justify-between">
                            <button type="button" id="previous-month" class="rounded-md border px-3 py-1 text-sm text-gray-700">
                                Precedent
                            </button>

                            <h3 id="calendar-title" class="font-semibold text-gray-900"></h3>

                            <button type="button" id="next-month" class="rounded-md border px-3 py-1 text-sm text-gray-700">
                                Suivant
                            </button>
                        </div>

                        <div class="mt-4 grid grid-cols-7 gap-2 text-center text-sm font-semibold text-gray-600">
                            <div>Lun</div>
                            <div>Mar</div>
                            <div>Mer</div>
                            <div>Jeu</div>
                            <div>Ven</div>
                            <div>Sam</div>
                            <div>Dim</div>
                        </div>

                        <div id="calendar-days" class="mt-2 grid grid-cols-7 gap-2"></div>

                        <div class="mt-4 flex items-center gap-4 text-sm text-gray-600">
                            <span class="inline-flex items-center gap-2">
                                <span class="h-3 w-3 rounded bg-indigo-600"></span>
                                Seance reservee
                            </span>

                            <button type="button" id="clear-date-filter" class="text-indigo-600 font-semibold">
                                Voir toutes les seances
                            </button>
                        </div>
                    </div>

                    <div class="mt-6 overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-gray-600 border-b">
                                <tr>
                                    <th class="py-3">Coach</th>
                                    <th class="py-3">Date</th>
                                    <th class="py-3">Heure</th>
                                    <th class="py-3">Statut</th>
                                    <th class="py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sessions as $session)
                                    <tr class="border-b session-row" data-date="{{ $session->session_date }}">
                                        <td class="py-3">{{ $session->coach?->name ?? '-' }}</td>
                                        <td class="py-3">{{ $session->session_date }}</td>
                                        <td class="py-3">
                                            {{ substr($session->start_time, 0, 5) }}
                                            -
                                            {{ substr($session->end_time, 0, 5) }}
                                        </td>
                                        <td class="py-3">
                                            @if ($session->status === 'pending')
                                                <span class="text-yellow-600">En attente</span>
                                            @elseif ($session->status === 'confirmed')
                                                <span class="text-green-600">Confirmee</span>
                                            @elseif ($session->status === 'cancelled')
                                                <span class="text-red-600">Annulee</span>
                                            @else
                                                {{ $session->status }}
                                            @endif
                                        </td>
                                        <td class="py-3">-</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 text-gray-600">Aucune seance.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const sessionDates = @json($sessions->pluck('session_date')->unique()->values());
        const calendarDays = document.getElementById('calendar-days');
        const calendarTitle = document.getElementById('calendar-title');
        const previousMonthButton = document.getElementById('previous-month');
        const nextMonthButton = document.getElementById('next-month');
        const clearDateFilterButton = document.getElementById('clear-date-filter');
        const sessionRows = document.querySelectorAll('.session-row');

        const monthNames = [
            'Janvier',
            'Fevrier',
            'Mars',
            'Avril',
            'Mai',
            'Juin',
            'Juillet',
            'Aout',
            'Septembre',
            'Octobre',
            'Novembre',
            'Decembre',
        ];

        let selectedDate = null;
        let currentDate = new Date();

        if (sessionDates.length > 0) {
            const firstDateParts = sessionDates[0].split('-');
            currentDate = new Date(firstDateParts[0], firstDateParts[1] - 1, 1);
        }

        function formatDate(year, month, day) {
            const monthText = String(month + 1).padStart(2, '0');
            const dayText = String(day).padStart(2, '0');

            return `${year}-${monthText}-${dayText}`;
        }

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const emptyDays = (firstDay.getDay() + 6) % 7;

            calendarTitle.textContent = `${monthNames[month]} ${year}`;
            calendarDays.innerHTML = '';

            for (let i = 0; i < emptyDays; i++) {
                calendarDays.appendChild(document.createElement('div'));
            }

            for (let day = 1; day <= lastDay.getDate(); day++) {
                const dateText = formatDate(year, month, day);
                const hasSession = sessionDates.includes(dateText);
                const button = document.createElement('button');

                button.type = 'button';
                button.textContent = day;
                button.className = 'rounded-md border p-2 text-sm';

                if (hasSession) {
                    button.className += ' border-indigo-600 bg-indigo-50 font-semibold text-indigo-700';
                } else {
                    button.className += ' text-gray-400';
                    button.disabled = true;
                }

                if (selectedDate === dateText) {
                    button.className += ' ring-2 ring-indigo-600';
                }

                button.addEventListener('click', function () {
                    selectedDate = dateText;
                    filterSessions();
                    renderCalendar();
                });

                calendarDays.appendChild(button);
            }
        }

        function filterSessions() {
            sessionRows.forEach(function (row) {
                row.classList.toggle('hidden', selectedDate && row.dataset.date !== selectedDate);
            });
        }

        previousMonthButton.addEventListener('click', function () {
            currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
            renderCalendar();
        });

        nextMonthButton.addEventListener('click', function () {
            currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
            renderCalendar();
        });

        clearDateFilterButton.addEventListener('click', function () {
            selectedDate = null;
            filterSessions();
            renderCalendar();
        });

        renderCalendar();
    </script>
</x-app-layout>
