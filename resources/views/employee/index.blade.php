<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Karyawan') }}
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
                            {{ __('Data Karyawan') }}
                        </h2>
                    </div>

                    <button x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'tambah-karyawan-modal')"
                        class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Tambah Karyawan Baru
                    </button>


                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="px-2 py-1">#</th>
                                    <th class="px-4 py-2">Id Karyawan</th>
                                    <th class="px-4 py-2">Nama</th>
                                    <th class="px-4 py-2">Nama Departement</th>
                                    <th class="px-4 py-2">Alamat</th>
                                    <th class="px-4 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employee as $emp)
                                    <tr class="text-center">
                                        <td class="border px-2 py-1">{{ $loop->iteration }}</td>
                                        <td class="border px-4 py-2">{{ $emp->employee_id }}</td>
                                        <td class="border px-4 py-2">{{ $emp->name }}</td>
                                        <td class="border px-4 py-2">{{ $emp->departement->departement_name }}</td>
                                        <td class="border px-4 py-2">{{ $emp->address }}</td>
                                        <td class="border px-4 py-2">
                                            <a href="#" x-data
                                                x-on:click.prevent="$dispatch('open-modal', 'edit-karyawan-modal-{{ $emp->id }}')"
                                                class="text-blue-600">
                                                Edit
                                            </a>
                                            |
                                            <a href="#"
                                                onclick="event.preventDefault(); if (confirm('Apakah Anda Yakin Ingin Menghapus Data Karyawan Ini?')) { document.getElementById('delete-form-{{ $emp->id }}').submit(); }"
                                                class="text-red-600">Hapus</a>
                                            <form id="delete-form-{{ $emp->id }}"
                                                action="{{ route('employee.destroy', $emp->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- modal edit --}}
                                    <x-modal name="edit-karyawan-modal-{{ $emp->id }}" :show="session('openModal') === 'edit-karyawan-modal-' . $emp->id || old('id') == $emp->id"
                                        maxWidth="md">

                                        <div class="p-6">
                                            <h2 class="text-lg font-medium text-gray-900">Edit Karyawan:
                                                {{ $emp->name }}</h2>

                                            <form method="POST" action="{{ route('employee.update', $emp->id) }}"
                                                class="mt-4 space-y-4">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id" value="{{ $emp->id }}">

                                                <div>
                                                    <x-input-label for="departement_id" :value="'Departement'" />
                                                    <select name="departement_id" id="departement_id"
                                                        class="mt-1 block w-full border-gray-300 rounded-md">
                                                        @foreach ($departement as $dept)
                                                            <option value="{{ $dept->id }}"
                                                                {{ old('departement_id', $emp->departement_id) == $dept->id ? 'selected' : '' }}>
                                                                {{ $dept->departement_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <x-input-error :messages="$errors->get('departement_id')" class="mt-2" />
                                                </div>

                                                <div>
                                                    <x-input-label for="name" :value="'Nama'" />
                                                    <x-text-input id="name" name="name" type="text"
                                                        class="mt-1 block w-full" :value="old('name', $emp->name)" required />
                                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                                </div>

                                                <div>
                                                    <x-input-label for="address" :value="'Alamat'" />
                                                    <textarea name="address" id="address" class="mt-1 block w-full rounded-md">{{ old('address', $emp->address) }}</textarea>
                                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                                </div>

                                                <div class="flex justify-end mt-4">
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
                                        <td class="border px-4 py-2 text-center" colspan="6">Belum Ada Data Karyawan
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- modal create --}}
            <x-modal name="tambah-karyawan-modal" :show="session('openModal') === 'tambah-karyawan-modal' || $errors->any()" maxWidth="md">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">Tambah Karyawan</h2>

                    <form method="post" action="{{ route('employee.store') }}" class="mt-4 space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="departement_id" :value="'Departement'" />
                            <select name="departement_id" id="departement_id"
                                class="mt-1 block w-full border-gray-300 rounded-md">
                                <option value="">-- Pilih Departement --</option>
                                @foreach ($departement as $dept)
                                    <option value="{{ $dept->id }}"
                                        {{ old('departement_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->departement_name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('departement_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="name" :value="'Nama'" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="address" :value="'Alamat'" />
                            <textarea name="address" id="address" class="mt-1 block w-full rounded-md">{{ old('address') }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div class="flex justify-end mt-4">
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
