<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reserver une seance
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Nouvelle reservation</h3>

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
                                Creneau disponible
                            </span>

                            <button type="button" id="clear-date-filter" class="text-indigo-600 font-semibold">
                                Voir tous les creneaux
                            </button>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('adherent.reservation.store') }}" class="mt-6 space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="availability_id" value="Plage disponible" />
                            <select id="availability_id" name="availability_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">Choisir une plage horaire</option>
                                @foreach ($availabilities as $availability)
                                    <option value="{{ $availability->id }}" data-date="{{ $availability->available_date }}" @selected(old('availability_id') == $availability->id)>
                                        {{ $availability->coach?->name }}
                                        -
                                        {{ $availability->coach?->coachProfile?->specialty ?? 'Sans specialite' }}
                                        -
                                        {{ $availability->available_date }}
                                        de {{ substr($availability->start_time, 0, 5) }}
                                        a {{ substr($availability->end_time, 0, 5) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('availability_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="notes" value="Notes" />
                            <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        @if ($availabilities->isEmpty())
                            <p class="text-sm text-gray-600">Aucune plage horaire disponible pour le moment.</p>
                        @endif

                        <x-primary-button @disabled($availabilities->isEmpty())>
                            Reserver
                        </x-primary-button>
                    </form>

                    <div class="mt-10">
                        <h3 class="text-lg font-semibold text-gray-900">Creneaux disponibles</h3>

                        <div class="mt-4 overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-gray-600 border-b">
                                    <tr>
                                        <th class="py-3">Coach</th>
                                        <th class="py-3">Specialite</th>
                                        <th class="py-3">Date</th>
                                        <th class="py-3">Debut</th>
                                        <th class="py-3">Fin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($availabilities as $availability)
                                        <tr class="border-b availability-row" data-date="{{ $availability->available_date }}">
                                            <td class="py-3">{{ $availability->coach?->name ?? '-' }}</td>
                                            <td class="py-3">{{ $availability->coach?->coachProfile?->specialty ?? '-' }}</td>
                                            <td class="py-3">{{ $availability->available_date }}</td>
                                            <td class="py-3">{{ substr($availability->start_time, 0, 5) }}</td>
                                            <td class="py-3">{{ substr($availability->end_time, 0, 5) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-4 text-gray-600">
                                                Aucun creneau disponible pour le moment.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const availableDates = @json($availabilities->pluck('available_date')->unique()->values());
        const calendarDays = document.getElementById('calendar-days');
        const calendarTitle = document.getElementById('calendar-title');
        const previousMonthButton = document.getElementById('previous-month');
        const nextMonthButton = document.getElementById('next-month');
        const clearDateFilterButton = document.getElementById('clear-date-filter');
        const availabilitySelect = document.getElementById('availability_id');
        const availabilityRows = document.querySelectorAll('.availability-row');

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

        if (availableDates.length > 0) {
            const firstDateParts = availableDates[0].split('-');
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
                const emptyCell = document.createElement('div');
                calendarDays.appendChild(emptyCell);
            }

            for (let day = 1; day <= lastDay.getDate(); day++) {
                const dateText = formatDate(year, month, day);
                const hasAvailability = availableDates.includes(dateText);
                const button = document.createElement('button');

                button.type = 'button';
                button.textContent = day;
                button.className = 'rounded-md border p-2 text-sm';

                if (hasAvailability) {
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
                    filterAvailabilities();
                    renderCalendar();
                });

                calendarDays.appendChild(button);
            }
        }

        function filterAvailabilities() {
            availabilityRows.forEach(function (row) {
                row.classList.toggle('hidden', selectedDate && row.dataset.date !== selectedDate);
            });

            Array.from(availabilitySelect.options).forEach(function (option) {
                if (! option.dataset.date) {
                    option.hidden = false;
                    return;
                }

                option.hidden = selectedDate && option.dataset.date !== selectedDate;
            });

            availabilitySelect.value = '';
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
            filterAvailabilities();
            renderCalendar();
        });

        renderCalendar();
    </script>
</x-app-layout>
