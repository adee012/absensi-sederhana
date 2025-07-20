<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Tambah Karyawan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded">
                <form method="POST" action="{{ route('employee.store') }}">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="employee_id" value="Employee ID" />
                        <x-text-input id="employee_id" name="employee_id" class="block mt-1 w-full" :value="old('employee_id')"
                            required />
                        <x-input-error :messages="$errors->get('employee_id')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="name" value="Nama" />
                        <x-text-input id="name" name="name" class="block mt-1 w-full" :value="old('name')"
                            required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="departement_id" value="Departement" />
                        <select id="departement_id" name="departement_id" class="block w-full border-gray-300 rounded">
                            <option value="">-- Pilih Departement --</option>
                            @foreach ($departements as $dept)
                                <option value="{{ $dept->id }}"
                                    {{ old('departement_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->departement_name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('departement_id')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="address" value="Alamat" />
                        <textarea name="address" id="address" rows="3" class="block mt-1 w-full border-gray-300 rounded">{{ old('address') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <x-secondary-button onclick="history.back()">Batal</x-secondary-button>
                        <x-primary-button class="ml-3">Simpan</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
