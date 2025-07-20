<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Absensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6 ">
                <div class="p-6 text-gray-900 ">
                    <div class="mb-5 flex items-center justify-center">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Data Riwayat Absen') }}
                        </h2>
                    </div>

                    <form method="GET" class="mb-4 flex flex-wrap gap-4">
                        <div>
                            <label class="block mb-1 font-medium text-sm text-gray-700">Departemen</label>
                            <select name="departement_id" class="border-gray-300 rounded-md shadow-sm w-full">
                                <option value="">-- Semua Departemen --</option>
                                @foreach ($departements as $dept)
                                    <option value="{{ $dept->id }}"
                                        {{ request('departement_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->departement_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1 font-medium text-sm text-gray-700">Tanggal</label>
                            <input type="date" name="date" value="{{ request('date') }}"
                                class="border-gray-300 rounded-md shadow-sm w-full">
                        </div>

                        <div class="flex items-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
                                Filter
                            </button>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class=" min-w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Tanggal</th>
                                    <th class="px-4 py-2">ID Karyawan</th>
                                    <th class="px-4 py-2">Nama</th>
                                    <th class="px-4 py-2">Departemen</th>
                                    <th class="px-4 py-2">Tipe Absen</th>
                                    <th class="px-4 py-2">Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody class="">
                                @forelse ($histories as $history)
                                    <tr class="text-center">
                                        <td class="border px-4 py-2">
                                            {{ \Carbon\Carbon::parse($history->date_attendance)->format('d-m-Y H:i') }}
                                        </td>
                                        <td class="border px-4 py-2">{{ $history->employee_id }}</td>
                                        <td class="border px-4 py-2">{{ $history->employee->name ?? '-' }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            {{ $history->employee->departement->departement_name ?? '-' }}</td>
                                        <td class="border px-4 py-2">
                                            {{ $history->attendance_type == 1 ? 'Masuk' : 'Keluar' }}
                                        </td>
                                        <td class="border px-4 py-2">{{ $history->description }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="border px-4 py-2 text-center">Data tidak
                                            ditemukan.</td>
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
