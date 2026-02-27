<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>invitation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md">

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-lg p-8">

            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                Invitation
            </h1>

            <div class="w-full flex justify-between">
                <!-- Form -->
            <form action="{{ route('flatshare.process.refuse',$token) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <div class="flex justify-between items-center pt-4">

                    <button 
                        class="bg-blue-100 text-gray-500 hover:underline text-sm px-5 py-2 rounded-lg font-semibold transition duration-200 shadow">
                        Refuser
                    </button>

                </div>

            </form>
            <form action="{{ route('flatshare.process.accept',$token) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <div class="flex justify-between items-center pt-4">

                    <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition duration-200 shadow">
                        Accept
                    </button>

                </div>

            </form>
            </div>
            

        </div>

    </div>

</body>
</html>