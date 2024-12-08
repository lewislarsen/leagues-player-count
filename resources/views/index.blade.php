<!doctype html>
<html lang="en">
<head>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Character Set -->
    <meta charset="UTF-8">

    <!-- Viewport for Responsive Design -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Compatibility -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Page Title -->
    <title>{{ __('Recent Leagues Player Activity') }}</title>

    <!-- Meta Descriptions for SEO -->
    <meta name="description" content="Track recent player activity during OSRS Leagues. View average player counts for Leagues worlds and stay updated on upcoming events.">
    <meta name="keywords" content="OSRS, Leagues, player activity, Old School RuneScape, Leagues event, player count, OSRS Leagues data">

    <!-- Favicons -->
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">

    <!-- Open Graph Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ __('Recent Leagues Player Activity') }}">
    <meta property="og:description" content="Track recent player activity during OSRS Leagues. View average player counts for Leagues worlds and stay updated on upcoming events.">
    <meta property="og:image" content="{{ asset('leagues.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ __('Recent Leagues Player Activity') }}">
    <meta name="twitter:description" content="Track recent player activity during OSRS Leagues. View average player counts for Leagues worlds and stay updated on upcoming events.">
    <meta name="twitter:image" content="{{ asset('leagues.png') }}">
</head>
<body class="bg-gray-800 text-gray-200 font-sans min-h-screen flex flex-col justify-between">
<!-- Main Container -->
<main class="max-w-3xl mx-auto mt-20 px-6 py-8 bg-gray-900 rounded-lg shadow-lg">
    <!-- Header Section -->
    <header class="text-center">
        <img src="{{ asset('leagues.png') }}" alt="{{ __('Leagues logo') }}" class="h-28 w-auto mx-auto mb-6">
        <h1 class="text-3xl font-semibold">{{ __('Recent Leagues Player Activity') }}</h1>
        <p class="mt-4 text-gray-400">{{ __('Explore the average player counts in OSRS Leagues worlds over the past days.') }}</p>
    </header>

    <!-- Notification for Inactive Leagues -->
    @if (!$isWithinLeaguesPeriod)
        <section class="mt-6 p-4 bg-red-600 rounded-lg">
            <p>
                {{ __('Currently, the OSRS Leagues event is inactive. Check back later for updates on upcoming leagues!') }}
                <a href="https://secure.runescape.com/m=news" target="_blank" rel="noopener noreferrer" class="font-bold underline">
                    {{ __('Visit the Old School RuneScape news page for more details.') }}
                </a>
            </p>
        </section>
    @endif

    <!-- Player Data Section -->
    <section class="mt-8">
        <!-- Table Header -->
        <div class="grid grid-cols-2 gap-4 bg-gray-800 text-gray-300 font-bold py-3 px-4 rounded-t-lg">
            <span>{{ __('Date') }}</span>
            <span class="text-center">{{ __('Average League World Player Count') }}</span>
        </div>

        <!-- Table Data -->
        @foreach ($playerData as $dayData)
            <div class="grid grid-cols-2 gap-4 items-center py-3 px-4 bg-gray-700 border-b border-gray-600">
                <span>{{ $dayData['day'] }}</span>
                <span class="text-center">
                    {{ $dayData['avg_population'] > 0 ? number_format($dayData['avg_population']) : '—' }}
                </span>
            </div>
        @endforeach
    </section>
</main>

<!-- Footer Section -->
<footer class="bg-gray-900 py-4 text-center text-sm text-gray-500 mt-8">
    <p>
        {{ __('This project is open-source and uses player data sourced from the Old School RuneScape website. All images are the property of Jagex.') }}
        <a href="https://github.com/lewislarsen/leagues-player-count" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:underline">
            {{ __('View the project on GitHub') }}
        </a>
    </p>
</footer>
</body>
</html>
