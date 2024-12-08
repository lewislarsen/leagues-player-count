<!doctype html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Leagues Player Activity</title>
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <link rel="manifest" href="/site.webmanifest" />
</head>
<body class="bg-gray-800 h-full flex justify-center items-center">
<div class="max-w-3xl mt-20 mx-auto px-6 py-8 bg-gray-900 rounded-lg shadow-lg">
    <h1 class="text-gray-50 text-3xl font-medium text-center">
        {{ __('Recent Leagues Player Data') }}
    </h1>
    <div class="mt-8">
        <div class="grid grid-cols-5 gap-4">
            <div class="bg-gray-900 rounded-lg text-white text-sm p-4 font-semibold text-center">
                {{ __('Date') }}
            </div>
            <div class="bg-gray-900 rounded-lg text-white text-sm p-4 font-semibold text-center">
                {{ __('Players Count') }}
            </div>
        </div>

        <!-- Loop through the player data for the last 8 days -->
        @foreach ($playerData as $dayData)
            <div class="grid grid-cols-5 gap-4 mt-4">
                <div class="bg-gray-700 rounded-lg text-white text-sm p-4 text-center">
                    {{ $dayData['day'] }}
                </div>
                <div class="bg-gray-700 rounded-lg text-white text-sm p-4 text-center">
                    {{ $dayData['player_count'] > 0 ? $dayData['player_count'] : '—' }}
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
