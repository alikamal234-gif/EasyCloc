<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Expense</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="bg-white w-full max-w-lg p-8 rounded-xl shadow">

    <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
        Edit Expense
    </h1>

    <form action="{{ route('expense.update', $expense->id) }}"
          method="POST"
          class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Title
            </label>
            <input type="text"
                   name="title"
                   value="{{ old('title', $expense->title) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Amount (DH)
            </label>
            <input type="number"
                   step="0.01"
                   name="amount"
                   value="{{ old('amount', $expense->amount) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Date
            </label>
            <input type="date"
                   name="date"
                   value="{{ old('date', \Carbon\Carbon::parse($expense->date)->format('Y-m-d')) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Category
            </label>
            <select name="category_id"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                    required>

               @foreach ($expense->flatshare->categories as $category)
                   <option value="{{ $category->id }}" {{ $category->id == $expense->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
               @endforeach

            </select>
        </div>

        <div class="flex justify-between items-center">

            <a href="{{ route('flatshare.show', $expense->flatshare_id) }}"
               class="text-gray-600 hover:underline text-sm">
                Cancel
            </a>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                Update Expense
            </button>

        </div>

    </form>

</div>

</body>
</html>