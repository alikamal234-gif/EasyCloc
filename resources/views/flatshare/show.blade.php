<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $flatshare->name }} | EasyColoc</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50">

<div class="flex min-h-screen">

    <!-- 🔷 SIDEBAR -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col">

        <div class="p-6 border-b border-slate-700">
            <h1 class="text-xl font-bold tracking-wide">
                EasyColoc
            </h1>
        </div>

        <nav class="flex-1 p-6 space-y-4 text-sm">

            <a href="{{ route('dashboard') }}"
               class="block hover:text-blue-400 transition">
                Dashboard
            </a>

            <a href="{{ route('flatshare.index') }}"
               class="block hover:text-blue-400 transition">
                My Flatshares
            </a>

            <a href="{{ route('profile.edit') }}"
               class="block hover:text-blue-400 transition">
                Profile
            </a>

        </nav>

        <div class="p-6 border-t border-slate-700">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="text-red-400 hover:text-red-300 text-sm">
                    Logout
                </button>
            </form>
        </div>

    </aside>


    <!-- 🔹 MAIN CONTENT -->
    <main class="flex-1 p-10">

        <!-- Header Section -->
        <div class="mb-10">

            <div class="flex justify-between items-start">

                <div>
                    <h2 class="text-3xl font-bold text-slate-800">
                        {{ $flatshare->name }}
                    </h2>

                    <p class="text-slate-500 mt-2">
                        {{ $flatshare->description }}
                    </p>

                    <span class="inline-block mt-3 px-3 py-1 text-xs rounded-full
                        {{ $flatshare->status === 'active'
                            ? 'bg-emerald-100 text-emerald-700'
                            : 'bg-rose-100 text-rose-700' }}">
                        {{ ucfirst($flatshare->status) }}
                    </span>
                </div>

                <div class="flex gap-3">

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
                            <button class="px-4 py-2 bg-rose-600 text-white rounded-md text-sm hover:bg-rose-700 transition">
                                Cancel
                            </button>
                        </form>
                    @else
                        <form action="{{ route('flatshare.exit', $flatshare->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button class="px-4 py-2 bg-rose-600 text-white rounded-md text-sm hover:bg-rose-700 transition">
                                Exit
                            </button>
                        </form>
                    @endif

                </div>

            </div>

        </div>


        <!-- MEMBERS GRID -->
        <div class="mb-12">
            <h3 class="text-lg font-semibold text-slate-700 mb-6">
                Members
            </h3>

            <div class="grid md:grid-cols-3 gap-6">

                @foreach($flatshare->users as $user)
                    @if($user->pivot->left_at == null)

                        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">

                            <p class="font-semibold text-slate-800">
                                {{ $user->name }}
                                @if($user->id === auth()->id())
                                    <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full ml-2">
                                        You
                                    </span>
                                @endif
                            </p>

                            <p class="text-xs text-slate-500 mt-2">
                                {{ ucfirst($user->pivot->internal_role) }}
                            </p>

                            <p class="text-sm mt-2 font-medium
                                {{ $user->reputation_score < 0
                                    ? 'text-rose-600'
                                    : ($user->reputation_score > 0
                                        ? 'text-emerald-600'
                                        : 'text-slate-600') }}">
                                Score: {{ $user->reputation_score }}
                            </p>

                        </div>

                    @endif
                @endforeach

            </div>
        </div>


        <!-- EXPENSES TABLE STYLE -->
        <div>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-slate-700">
                    Expenses
                </h3>

                <div class="flex gap-3">
                    <a href="{{ route('expense.create', $flatshare->id) }}"
                       class="px-4 py-2 bg-emerald-600 text-white text-sm rounded-md hover:bg-emerald-700 transition">
                        Add Expense
                    </a>

                    <a href="{{ route('expense.credit', $flatshare->id) }}"
                       class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700 transition">
                        Settlement
                    </a>
                </div>
            </div>

            @php
                $total = $flatshare->expenses->sum('amount');
            @endphp

            <div class="mb-4 text-sm text-slate-600">
                Total:
                <span class="font-semibold text-indigo-600">
                    {{ $total }} DH
                </span>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

                @forelse($flatshare->expenses as $expense)

                    <div class="flex justify-between items-center px-6 py-4 border-b last:border-none hover:bg-slate-50">

                        <div>
                            <p class="font-medium text-slate-800">
                                {{ $expense->title }}
                            </p>
                            <p class="text-xs text-slate-500">
                                {{ $expense->user->name }} • {{ $expense->date }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="font-semibold text-slate-900">
                                {{ $expense->amount }} DH
                            </p>
                            <p class="text-xs text-slate-500">
                                {{ $expense->category->name ?? 'No Category' }}
                            </p>
                        </div>

                    </div>

                @empty
                    <div class="text-center py-10 text-slate-500 text-sm">
                        No expenses yet.
                    </div>
                @endforelse

            </div>
        </div>

    </main>

</div>

</body>
</html>