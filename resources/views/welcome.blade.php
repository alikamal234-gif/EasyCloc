<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyColoc</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">

            <h1 class="text-xl font-bold text-blue-600">
                EasyColoc
            </h1>

            <div class="space-x-4">

                @guest
                    <a href="{{ route('login') }}"
                       class="text-gray-600 hover:text-blue-600 font-medium">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Register
                    </a>
                @endguest

                @auth
                    <a href="{{ route('flatshare.index') }}"
                       class="text-gray-600 hover:text-blue-600 font-medium">
                        Flatshares
                    </a>

                    <a href="{{ route('profile.edit') }}"
                       class="text-gray-600 hover:text-blue-600 font-medium">
                        Profile
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="text-red-600 hover:underline font-medium">
                            Logout
                        </button>
                    </form>
                @endauth

            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="flex-grow flex items-center justify-center">
        <div class="text-center max-w-2xl px-6">

            <h2 class="text-4xl font-bold text-gray-800 mb-4">
                Manage Your Flatshare Smartly
            </h2>

            <p class="text-gray-600 text-lg mb-8">
                Track shared expenses, calculate balances automatically,
                and know exactly who owes who — without manual calculations.
            </p>

            @guest
                <div class="space-x-4">
                    <a href="{{ route('register') }}"
                       class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition shadow">
                        Get Started
                    </a>

                    <a href="{{ route('login') }}"
                       class="border border-blue-600 text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition">
                        Login
                    </a>
                </div>
            @endguest

            @auth
                <a href="{{ route('flatshare.index') }}"
                   class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition shadow">
                    Go to My Flatshares
                </a>
            @endauth

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t py-4 text-center text-gray-500 text-sm">
        © {{ date('Y') }} EasyColoc - All rights reserved.
    </footer>

</body>
</html>