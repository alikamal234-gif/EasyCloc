<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settlement</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-5xl mx-auto py-10 px-4">

    <div class="bg-white p-6 rounded-xl shadow mb-8">
        <h1 class="text-2xl font-bold text-gray-800">
            Settlement - {{ $flatshare->name }}
        </h1>
        <p class="text-gray-500 mt-1">
            Overview of balances and payments {{ Auth()->user()->name }}
        </p>
    </div>

    <div class="grid md:grid-cols-3 gap-6 mb-10">

        <div class="bg-white p-6 rounded-xl shadow text-center">
            <p class="text-sm text-gray-500">Total Expenses</p>
            <p class="text-2xl font-bold text-blue-600 mt-2">
                {{ number_format($total,2) }} DH
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow text-center">
            <p class="text-sm text-gray-500">Share Per Member</p>
            <p class="text-2xl font-bold text-purple-600 mt-2">
                {{ number_format($share,2) }} DH
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow text-center">
            <p class="text-sm text-gray-500">Members</p>
            <p class="text-2xl font-bold text-gray-800 mt-2">
                {{ $flatshare->users->count() }}
            </p>
        </div>

    </div>

    @if(count($settlements) === 0)

        <div class="bg-white p-10 rounded-xl shadow text-center text-gray-500">
            Everyone is settled 🎉
        </div>

    @else

        <div class="bg-white rounded-xl shadow divide-y">

            @foreach($settlements as $settlement)

                <div class="p-6 flex justify-between items-center hover:bg-gray-50 transition">

                    <div>
                        <p class="text-gray-800 font-semibold text-lg">
                            {{ $settlement['from']->name }}
                            <span class="text-gray-400 mx-2">→</span>
                            {{ $settlement['to']->name }}
                        </p>

                        <p class="text-sm text-gray-500 mt-1">
                            Payment required
                        </p>
                    </div>

                    <div class="text-red-600 font-bold text-xl">
                        {{ number_format($settlement['amount'],2) }} DH
                        @if ($settlement['to']->name == Auth()->user()->name)
                            <form action="{{ route('payment.market') }}" method="POST">
                               @csrf
                               <input type="text" name="amount" id="" class="hidden" value="{{ $settlement['amount'] }}">
                               <input type="text" name="debtor_id" id="" class="hidden" value="{{ Auth()->id() }}">
                               <input type="text" name="creditor_id" id="" class="hidden" value="{{ $settlement['from']->id }}">
                               <input type="text" name="flatshare_id" id="" class="hidden" value="{{ $flatshare->id }}">
                               <button type="submit"
                                   class="bg-green-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 shadow">
                                   Mark as Paid
                               </button>
                           </form>
                        @else
                           <h5 class="text-black">is not paid</h5>
                        @endif
                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

</body>
</html>