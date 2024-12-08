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
<body class="bg-gray-800 h-full flex flex-col justify-center items-center">
<div class="max-w-3xl mt-20 mx-auto px-6 py-8 bg-gray-900 rounded-lg shadow-lg">
    <div class="mx-auto text-center">
        <img src="{{ asset('leagues.png') }}" alt="{{ __('Leagues logo') }}" title="{{ __('Leagues logo') }}" class="h-26 w-auto mb-8 inline" />
    </div>
    <h1 class="text-gray-50 text-3xl font-medium text-center mb-6">
        {{ __('Recent Leagues Player Data') }}
    </h1>

    <!-- Show message if leagues are not active -->
    @if (!$isWithinLeaguesPeriod)
        <div class="mt-4 p-4 bg-red-500 text-white text-base rounded-lg">
            <p>
                {{ __('Leagues are currently inactive. Stay tuned for updates on upcoming leagues!') }}
                <a href="https://secure.runescape.com/m=news" target="_blank" class="text-white font-bold underline">
                    {{ __('Check Old School RuneScape news posts for details.') }}
                </a>
            </p>
        </div>
    @endif

    <!-- Player Data Table -->
    <div class="mt-8">
        <!-- Table Header -->
        <div class="grid grid-cols-2 gap-4 bg-gray-800 text-white text-lg font-semibold py-3 px-4 rounded-t-lg">
            <div>{{ __('Date') }}</div>
            <div>{{ __('Avg. Leagues Player Count') }}</div>
        </div>
        <!-- Table Rows -->
        @foreach ($playerData as $dayData)
            <div class="grid grid-cols-2 gap-4 items-center py-3 px-4 bg-gray-700 text-white border-b border-gray-600">
                <div>{{ $dayData['day'] }}</div>
                <div class="text-center">
                    {{ $dayData['player_count'] > 0 ? number_format($dayData['player_count']) : '—' }}
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Footer -->
<footer class="mt-8 w-full text-center py-4 bg-gray-900 text-gray-400 text-sm">
    <p>
        {{ __('This project is open-source and uses data sourced from the Old School RuneScape website.') }}
        <a href="https://github.com/lewislarsen/leagues-player-count" target="_blank" class="text-blue-400 hover:underline">
            {{ __('View on GitHub') }}
        </a>
    </p>
</footer>
</body>
</html>
