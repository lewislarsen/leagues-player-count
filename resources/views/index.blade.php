<!doctype html>
<html lang="en">
<head>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Character Set -->
    <meta charset="UTF-8">

    <!-- Viewport settings for responsive design -->
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <!-- Internet Explorer Compatibility -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Page Title -->
    <title>{{ __('Recent Leagues Player Activity') }}</title>

    <!-- Meta Description for SEO -->
    <meta name="description" content="Track the recent player activity during OSRS Leagues. View average player counts for Leagues worlds and stay updated on upcoming events.">

    <!-- Meta Keywords for SEO -->
    <meta name="keywords" content="OSRS, Leagues, player activity, Old School RuneScape, Leagues event, player count, OSRS Leagues data">

    <!-- Favicon Icons -->
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <link rel="manifest" href="/site.webmanifest" />

    <!-- Open Graph Meta Tags (for better social media sharing) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ __('Recent Leagues Player Activity') }}">
    <meta property="og:description" content="Track the recent player activity during OSRS Leagues. View average player counts for Leagues worlds and stay updated on upcoming events.">
    <meta property="og:image" content="{{ asset('leagues.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ __('Recent Leagues Player Activity') }}">
    <meta name="twitter:description" content="Track the recent player activity during OSRS Leagues. View average player counts for Leagues worlds and stay updated on upcoming events.">
    <meta name="twitter:image" content="{{ asset('leagues.png') }}">
    <meta name="twitter:url" content="{{ url()->current() }}">
</head>
<body class="bg-gray-800 h-full flex flex-col justify-center items-center">
<div class="max-w-3xl mt-20 mx-auto px-6 py-8 bg-gray-900 rounded-lg shadow-lg">
    <div class="mx-auto text-center">
        <img src="{{ asset('leagues.png') }}" alt="{{ __('Leagues logo') }}" title="{{ __('Leagues logo') }}" class="h-26 w-auto mb-8 inline" />
    </div>
    <h1 class="text-gray-50 text-3xl font-medium text-center mb-6">
        {{ __('Recent Leagues Player Activity') }}
    </h1>

    <!-- Description of the page -->
    <p class="text-gray-400 text-lg text-center mb-6">
        {{ __('This page provides real-time data on player activity within the OSRS Leagues. The displayed information shows the average number of players on Leagues worlds over time.') }}
    </p>

    <!-- Show message if leagues are not active -->
    @if (!$isWithinLeaguesPeriod)
        <div class="mt-4 p-4 bg-red-500 text-white text-base rounded-lg">
            <p>
                {{ __('Currently, the OSRS Leagues event is inactive. Check back later for updates on upcoming leagues!') }}
                <a href="https://secure.runescape.com/m=news" target="_blank" class="text-white font-bold underline">
                    {{ __('Visit the Old School RuneScape news page for more details.') }}
                </a>
            </p>
        </div>
    @endif

    <!-- Player Data Table -->
    <div class="mt-8">
        <!-- Table Header -->
        <div class="grid grid-cols-2 gap-4 bg-gray-800 text-white text-lg font-semibold py-3 px-4 rounded-t-lg">
            <div>{{ __('Date') }}</div>
            <div>{{ __('Average League World Player Count') }}</div>
        </div>
        <!-- Table Rows -->
        @foreach ($playerData as $dayData)
            <div class="grid grid-cols-2 gap-4 items-center py-3 px-4 bg-gray-700 text-white border-b border-gray-600">
                <div>{{ $dayData['day'] }}</div>
                <div class="text-center">
                    {{ $dayData['avg_population'] > 0 ? number_format($dayData['avg_population']) : '—' }}
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Footer -->
<footer class="mt-8 w-full text-center py-4 bg-gray-900 text-gray-400 text-sm">
    <p>
        {{ __('This project is open-source and uses player data sourced from the Old School RuneScape website. All images are the property of Jagex.') }}
        <a href="https://github.com/lewislarsen/leagues-player-count" target="_blank" class="text-blue-400 hover:underline">
            {{ __('View the project on GitHub') }}
        </a>
    </p>
</footer>
</body>
</html>
