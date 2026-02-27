<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md">

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-lg p-8">

            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                Create New Category
            </h1>

            <!-- Form -->
            <form action="{{ route('category.store',$flatshareId) }}" method="POST" class="space-y-5">
                @csrf

                <!-- Category Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">
                        Category Name
                    </label>

                    <input type="text" name="name"
                        value="{{ old('name') }}"
                        placeholder="e.g. Groceries"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                  
                    @error('success')
                        <p class="text-green-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
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
                        Save Category
                    </button>

                </div>

            </form>

        </div>

    </div>

</body>
</html>