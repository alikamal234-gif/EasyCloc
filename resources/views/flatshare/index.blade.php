<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flatshares</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="max-w-5xl mx-auto py-10 px-4">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">
                My Flatshares
            </h1>

            @if($is_can)
                <a href="{{ route('flatshare.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                    + Create Flatshare
                </a>
            @else
                <span class="bg-gray-400 text-white px-4 py-2 rounded-lg cursor-not-allowed opacity-60">
                    + Create Flatshare
                </span>
            @endif
        </div>

        <!-- Cards -->
        <div class="grid md:grid-cols-2 gap-6">

            @foreach ($flatshares as $flatshare)

                    <div class="bg-white rounded-xl shadow p-6 border border-gray-100">

                        <h2 class="text-xl font-semibold text-gray-800 mb-2">
                            {{ $flatshare->name }}
                        </h2>

                        <p class="text-gray-600 mb-3">
                            {{ $flatshare->description }}
                        </p>

                        <span class="inline-block px-3 py-1 text-sm rounded-full
                                {{ $flatshare->status === 'active'
                ? 'bg-green-100 text-green-700'
                : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($flatshare->status) }}
                        </span>

                        <!-- Actions -->
                        <div class="flex items-center gap-4 mt-5">

                            <a href="{{ route('flatshare.show', $flatshare->id) }}"
                                class="text-blue-600 hover:underline text-sm">
                                View
                            </a>

                            <a href="{{ route('flatshare.edit', $flatshare->id) }}"
                                class="text-yellow-600 hover:underline text-sm">
                                Edit
                            </a>
                            <a href="{{ route('flatshare.invite', $flatshare->id) }}"
                                class="text-yellow-600 hover:underline text-sm">
                                Invite
                            </a>

                            <form action="{{ route('flatshare.cancel', $flatshare->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <button type="submit" class="text-red-600 hover:underline text-sm">
                                    Cancel
                                </button>
                            </form>

                        </div>

                    </div>

            @endforeach

        </div>

    </div>

</body>

</html>