<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Flatshare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white w-full max-w-md p-8 rounded-xl shadow-md">

        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            Edit Flatshare
        </h1>

        <form action="{{ route('flatshare.update', $flatshare->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Name
                </label>
                <input 
                    type="text" 
                    name="name"
                    value="{{ old('name', $flatshare->name) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Description
                </label>
                <textarea 
                    name="description"
                    rows="3"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >{{ old('description', $flatshare->description) }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between items-center">

                <a href="{{ route('flatshare.index') }}"
                   class="text-gray-600 hover:underline text-sm">
                    Cancel
                </a>

                <button 
                    type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition duration-200"
                >
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</body>
</html>