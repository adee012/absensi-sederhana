<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Departement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div id="flash-message"
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-3"
                    role="alert">
                    <strong class="font-bold">{{ session('success') }}</strong>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="closeFlashMessage()">
                        <svg class="fill-current h-6 w-6
                            text-green-500" role="button"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 text-gray-900 ">
                    <div class="mb-3 flex items-center justify-center">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Data Departement') }}
                        </h2>
                    </div>

                    <button x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'tambah-departement-modal')"
                        class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Tambah Departement
                    </button>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="px-2 py-1">#</th>
                                    <th class="px-4 py-2">Nama Departement</th>
                                    <th class="px-4 py-2">Jam Masuk Maksimal</th>
                                    <th class="px-4 py-2">Jam Pulang Maksimal</th>
                                    <th class="px-4 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($departement as $dpt)
                                    <tr class="text-center">
                                        <td class="border px-2 py-1">{{ $loop->iteration }}</td>
                                        <td class="border px-4 py-2">{{ $dpt->departement_name }}</td>
                                        <td class="border px-4 py-2">{{ $dpt->max_clock_in_time }}</td>
                                        <td class="border px-4 py-2">{{ $dpt->max_clock_out_time }}</td>
                                        <td class="border px-4 py-2">
                                            <a href="#" x-data
                                                x-on:click.prevent="$dispatch('open-modal', 'edit-departement-modal-{{ $dpt->id }}')"
                                                class="text-blue-600">
                                                Edit
                                            </a>
                                            |
                                            <a href="#"
                                                onclick="event.preventDefault(); if (confirm('Menghapus Departement Akan Menghapus Seluruh Data Yang Berkaitan Dengan Departement Ini?')) { document.getElementById('delete-form-{{ $dpt->id }}').submit(); }"
                                                class="text-red-600">Hapus</a>
                                            <form id="delete-form-{{ $dpt->id }}"
                                                action="{{ route('departement.destroy', $dpt->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- modal edit --}}
                                    <x-modal name="edit-departement-modal-{{ $dpt->id }}" :show="old('departement_name') && session('edit-departement-id') == $dpt->id"
                                        maxWidth="md">

                                        <div class="p-6">
                                            <h2 class="text-lg font-medium text-gray-900">
                                                Edit Departement
                                            </h2>

                                            <form method="POST" action="{{ route('departement.update', $dpt->id) }}"
                                                class="mt-2 space-y-6">
                                                @csrf
                                                @method('PUT')

                                                <div>
                                                    <x-input-label for="departement_name_{{ $dpt->id }}"
                                                        value="Nama Departement" />
                                                    <x-text-input id="departement_name_{{ $dpt->id }}"
                                                        name="departement_name" type="text" class="mt-1 block w-full"
                                                        value="{{ old('departement_name', $dpt->departement_name) }}"
                                                        required autofocus />
                                                    <x-input-error :messages="$errors->get('departement_name')" class="mt-2" />
                                                </div>

                                                <div>
                                                    <x-input-label for="max_clock_in_time_{{ $dpt->id }}"
                                                        value="Max Clock In" />
                                                    <x-text-input id="max_clock_in_time_{{ $dpt->id }}"
                                                        name="max_clock_in_time" type="time"
                                                        class="mt-1 block w-full"
                                                        value="{{ old('max_clock_in_time', $dpt->max_clock_in_time) }}"
                                                        required />
                                                    <x-input-error :messages="$errors->get('max_clock_in_time')" class="mt-2" />
                                                </div>

                                                <div>
                                                    <x-input-label for="max_clock_out_time_{{ $dpt->id }}"
                                                        value="Max Clock Out" />
                                                    <x-text-input id="max_clock_out_time_{{ $dpt->id }}"
                                                        name="max_clock_out_time" type="time"
                                                        class="mt-1 block w-full"
                                                        value="{{ old('max_clock_out_time', $dpt->max_clock_out_time) }}"
                                                        required />
                                                    <x-input-error :messages="$errors->get('max_clock_out_time')" class="mt-2" />
                                                </div>

                                                <div class="flex justify-end mt-6">
                                                    <x-secondary-button x-on:click="$dispatch('close')">
                                                        Batal
                                                    </x-secondary-button>

                                                    <x-primary-button class="ms-3">
                                                        Simpan
                                                    </x-primary-button>
                                                </div>
                                            </form>
                                        </div>
                                    </x-modal>

                                @empty
                                    <tr>
                                        <td class="border px-4 py-2 text-center" colspan="5">Belum Ada Departement
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            {{-- modal create --}}
            <x-modal name="tambah-departement-modal" :show="$errors->any()" maxWidth="md">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">
                        Tambah Departement
                    </h2>

                    <form method="post" action="{{ route('departement.store') }}" class="mt-2 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="departement_name" :value="__('Nama Departement')" />
                            <x-text-input id="departement_name" name="departement_name" type="text"
                                class="mt-1 block w-full" :value="old('departement_name')" required autofocus
                                autocomplete="departement_name" />
                            <x-input-error :messages="$errors->get('departement_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="max_clock_in_time" :value="__('Jam Masuk Maksimal')" />
                            <x-text-input id="max_clock_in_time" name="max_clock_in_time" type="time"
                                class="mt-1 block w-full" :value="old('max_clock_in_time')" required />
                            <x-input-error :messages="$errors->get('max_clock_in_time')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="max_clock_out_time" :value="__('Jam Pulang Maksimal')" />
                            <x-text-input id="max_clock_out_time" name="max_clock_out_time" type="time"
                                class="mt-1 block w-full" :value="old('max_clock_out_time')" required />
                            <x-input-error :messages="$errors->get('max_clock_out_time')" class="mt-2" />
                        </div>

                        <div class="flex justify-end mt-6">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                Batal
                            </x-secondary-button>

                            <x-primary-button class="ms-3">
                                Simpan
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </x-modal>

        </div>
    </div>
</x-app-layout>
