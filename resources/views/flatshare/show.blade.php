<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flatshare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="max-w-5xl mx-auto py-10 px-4">

        <!-- Header -->
        <div class="bg-white p-6 rounded-xl shadow mb-8">
            <div class="flex justify-between items-start">

                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        {{ $flatshare->name }}
                    </h1>
                    <p class="text-gray-600 mt-2">
                        {{ $flatshare->description }}
                    </p>

                    <span class="inline-block mt-3 px-3 py-1 text-sm rounded-full
                    {{ $flatshare->status === 'active'
    ? 'bg-green-100 text-green-700'
    : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($flatshare->status) }}
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="space-x-2">

                    @php
                        $pivot = $flatshare->users
                            ->where('id', auth()->id())
                            ->first()
                            ->pivot ?? null;
                    @endphp

                    @if($pivot && $pivot->internal_role === 'owner')
                        <form action="{{ route('flatshare.cancel', $flatshare->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <button type="submit"  
                                @if($members > 1)
                                    disabled
                                @endif
                                class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                                Cancel
                            </button>
                        </form>
                    @else
                        <form action="{{ route('flatshare.cancel', $flatshare->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <button type="submit"
                                class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                                Exit
                            </button>
                        </form>
                    @endif

                </div>

            </div>
        </div>

        <!-- Members Section -->
        <div class="bg-white p-6 rounded-xl shadow mb-8">
            <h2 class="text-lg font-semibold mb-4 text-gray-800">
                Members
            </h2>

            <div class="space-y-3">
                @foreach($flatshare->users as $user)
                    <div class="flex justify-between items-center border-b pb-2">

                        <div>
                            <p class="font-medium text-gray-700">
                                {{ $user->name }}
                            </p>
                            <span class="text-sm text-gray-500">
                                {{ ucfirst($user->pivot->internal_role) }}
                            </span>
                        </div>

                        @if(
                                $pivot && $pivot->internal_role === 'owner'
                                && $user->id !== auth()->id()
                            )
                            <button class="text-blue-600 text-sm hover:underline">
                                Make Owner
                            </button>
                        @endif

                    </div>
                @endforeach
            </div>
        </div>

        <!-- Expenses Section -->
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold text-gray-800">
                    Expenses
                </h2>

                @if($flatshare->status === 'active')
                    <a href="{{ route('expense.create', $flatshare->id) }}"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                        + Add Expense
                    </a>
                    <a href="{{ route('expense.credit', $flatshare->id) }}"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                        creadit
                    </a>
                @endif
            </div>

            @php
                $total = $flatshare->expenses->sum('amount');
            @endphp

            <!-- Total -->
            <div class="mb-4 text-sm text-gray-600">
                Total Expenses:
                <span class="font-semibold text-blue-600">
                    {{ $total }} DH
                </span>
            </div>
            @php
                $membersSummary = [];

                foreach ($flatshare->users as $member) {
                    $paid = $flatshare->expenses
                        ->where('user_id', $member->id)
                        ->sum('amount');

                    $membersSummary[] = [
                        'name' => $member->name,
                        'paid' => $paid
                    ];
                }
            @endphp

            <!-- Members Contribution -->
            <div class="mb-6">
                <h3 class="text-md font-semibold text-gray-800 mb-3">
                    Members Contribution
                </h3>

                <div class="grid md:grid-cols-2 gap-4">

                    @foreach($membersSummary as $member)

                        <div class="bg-gray-50 border rounded-lg p-4 flex justify-between items-center">

                            <span class="text-gray-700 font-medium">
                                {{ $member['name'] }}
                            </span>

                            <span class="text-blue-600 font-semibold">
                                {{ $member['paid'] }} DH
                            </span>

                        </div>

                    @endforeach

                </div>
            </div>
            <!-- Expenses List -->
            <div class="space-y-4">

                @forelse($flatshare->expenses as $expense)

                    <div class="border rounded-lg p-4 flex justify-between items-center">

                        <div>
                            <p class="font-medium text-gray-800">
                                {{ $expense->title }}
                            </p>

                            <p class="text-sm text-gray-500">
                                Paid by: {{ $expense->user->name }}
                            </p>

                            <p class="text-xs text-gray-400">
                                {{ $expense->date }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="font-semibold text-blue-600">
                                {{ $expense->amount }} DH
                            </p>

                            <p class="text-xs text-gray-400">
                                {{ $expense->category->name ?? 'No Category' }}
                            </p>
                        </div>
                        <a href="{{ route('expense.edit', $expense->id) }}">edit</a>
                       
                    </div>

                @empty
                    <div class="text-gray-500 text-sm text-center py-6">
                        No expenses added yet.
                    </div>
                @endforelse

            </div>
        </div>

    </div>

</body>

</html>