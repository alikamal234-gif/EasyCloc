<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Expense</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="bg-white w-full max-w-lg p-8 rounded-xl shadow">

    <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
        Add Expense
    </h1>

    <form action="{{ route('expense.store', $flatshare->id) }}" 
          method="POST" 
          class="space-y-5">
        @csrf

        <!-- Title -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Title
            </label>
            <input type="text"
                   name="title"
                   value="{{ old('title') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <!-- Amount -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Amount (DH)
            </label>
            <input type="number"
                   step="0.01"
                   name="amount"
                   value="{{ old('amount') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <!-- Date -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Date
            </label>
            <input type="date"
                   name="date"
                   value="{{ old('date', date('Y-m-d')) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <!-- Category -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Category
            </label>
            <select name="category_id"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                    required>
                <option value="">Select Category</option>

                @foreach($flatshare->categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <!-- Hidden Fields -->
        <input type="hidden" name="flatshare_id" value="{{ $flatshare->id }}">
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

        <!-- Buttons -->
        <div class="flex justify-between items-center">

            <a href="{{ route('flatshare.show', $flatshare->id) }}"
               class="text-gray-600 hover:underline text-sm">
                Cancel
            </a>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                Save Expense
            </button>

        </div>

    </form>

</div>

</body>
</html>