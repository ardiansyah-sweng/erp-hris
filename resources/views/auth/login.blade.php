<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ERP HRIS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">
                ERP HRIS
            </h1>
            <p class="text-sm text-gray-500 mt-2">
                Silakan login untuk melanjutkan
            </p>
        </div>

        @if(session('error'))
            <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-600 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="/login" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    placeholder="nama@email.com"
                    required
                >
            </div>

            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 pr-10 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    placeholder="password"
                    required
                >

                <button
                    type="button"
                    onclick="togglePassword()"
                    class="absolute right-3 top-9 text-gray-500"
                >
                    <span id="eye-open">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5
                                    c4.477 0 8.268 2.943 9.542 7
                                    -1.274 4.057-5.065 7-9.542 7
                                    -4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </span>

                    <span id="eye-close" class="hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5
                                    c4.477 0 8.268 2.943 9.542 7
                                    -1.274 4.057-5.065 7-9.542 7
                                    -4.477 0-8.268-2.943-9.542-7z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6.1 6.1L3 3m18 18l-3.1-3.1
                                    M9.878 9.878l4.242 4.242
                                    M21 21L3 3" />
                        </svg>
                    </span>
                </button>
            </div>

            <button
                type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 rounded-lg transition"
            >
                Login
            </button>
        </form>

    </div>
</div>

<script>
function togglePassword() {
    const password = document.getElementById('password');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClose = document.getElementById('eye-close');

    if (password.type === 'password') {
        password.type = 'text';
        eyeOpen.classList.add('hidden');
        eyeClose.classList.remove('hidden');
    } else {
        password.type = 'password';
        eyeOpen.classList.remove('hidden');
        eyeClose.classList.add('hidden');
    }
}
</script>
</body>
</html>