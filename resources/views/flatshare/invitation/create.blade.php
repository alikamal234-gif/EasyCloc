<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create invitation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md">

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-lg p-8">

            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                Create New Invitation
            </h1>

            <!-- Form -->
            <form action="{{ route('flatshare.invite.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Category Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">
                        email
                    </label>

                    <input type="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="ali@gmail.com"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                  
                    
                </div>

                <!-- Hidden flatshare -->
                <input type="hidden" name="flatshare_id" value="{{ $flatshareId ?? '' }}">

                <!-- Buttons -->
                <div class="flex justify-between items-center pt-4">

                    <a href="{{ url()->previous() }}"
                        class="text-gray-500 hover:underline text-sm">
                        Cancel
                    </a>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition duration-200 shadow">
                        Send Invitation
                    </button>

                </div>

            </form>

        </div>

    </div>

</body>
</html>