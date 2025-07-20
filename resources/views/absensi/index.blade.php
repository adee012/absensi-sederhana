<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Absensi Karyawan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white m-5 p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6">Absensi Karyawan</h1>

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
        @elseif (session('error'))
            <div id="flash-message"
                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-3" role="alert">
                <strong class="font-bold">{{ session('error') }}</strong>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="closeFlashMessage()">
                    <svg class="fill-current h-6 w-6
                            text-red-500" role="button"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                            d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                    </svg>
                </span>
            </div>
        @endif

        <form id="absenForm" method="POST">
            @csrf
            <div class="mb-4">
                <label for="employee_id" class="block font-semibold mb-1">Employee ID</label>
                <input type="text" name="employee_id" id="employee_id" class="w-full border rounded p-2" required>
                @error('employee_id')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div id="employeeInfo" class="mb-4 hidden bg-gray-100 p-2 rounded">
                <p><strong>Nama:</strong> <span id="empName"></span></p>
                <p><strong>Departemen:</strong> <span id="empDept"></span></p>
            </div>

            <div class="flex justify-between mt-6">
                <button formaction="{{ route('absensi.masuk') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Absen Masuk</button>
                <button formaction="{{ route('absensi.keluar') }}"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Absen Keluar</button>
            </div>
        </form>

        <div class="mt-4">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline hover:text-blue-700 font-light">
                Klik di sini untuk login sebagai admin.
            </a>
        </div>

    </div>

    <script>
        const empInput = document.getElementById('employee_id');
        const empName = document.getElementById('empName');
        const empDept = document.getElementById('empDept');
        const empInfo = document.getElementById('employeeInfo');

        empInput.addEventListener('input', () => {
            const id = empInput.value.trim();
            if (id.length < 3) {
                empInfo.classList.add('hidden');
                return;
            }

            fetch(`/api/get-employee/${id}`)
                .then(res => {
                    if (!res.ok) throw new Error();
                    return res.json();
                })
                .then(data => {
                    empName.textContent = data.name;
                    empDept.textContent = data.departement;
                    empInfo.classList.remove('hidden');
                })
                .catch(() => {
                    empName.textContent = '';
                    empDept.textContent = '';
                    empInfo.classList.add('hidden');
                });
        });

        function closeFlashMessage() {
            document.getElementById('flash-message').style.display = 'none';
        }
    </script>

</body>

</html>
