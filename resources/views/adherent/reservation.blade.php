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

                    <form class="mt-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Coach</label>
                            <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option>Choisir un coach</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Heure</label>
                            <input type="time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <x-primary-button>Reserver</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
