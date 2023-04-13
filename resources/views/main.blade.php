<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ИдёмВКино</title>
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
</head>
<body>
    <header class="page-header">
        <h1 class="page-header__title">Идём<span>в</span>кино</h1>
    </header>
    @if (Route::has('login'))
        <div class="block_login">
            @auth
                <a href="{{ url('/home') }}" class="link_login font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
            @else
                <a href="{{ route('login') }}" class="link_login font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                @endif
            @endauth
        </div>
    @endif

        <nav class="page-nav"></nav>

        <main>
            @foreach($films as $film)
            <section class="movie">
                <div class="movie__info">
                    <div class="movie__poster">
                        <img class="movie__poster-image" alt="Звёздные войны постер" src="i/poster1.jpg">
                    </div>
                    <div class="movie__description">
                        <h2 class="movie__title">{{ $film->title }}</h2>
                        <p class="movie__synopsis">Две сотни лет назад малороссийские хутора разоряла шайка нехристей-ляхов во главе с могущественным колдуном.</p>
                        <p class="movie__data">
                            <span class="movie__data-duration">{{ $film->duration }} минут</span>
                            <span class="movie__data-origin">США</span>
                        </p>
                    </div>
                </div>

                @foreach($halls as $hall)
                <div class="movie-seances__hall">
                    <h3 class="movie-seances__hall-title">{{ $hall->title }}</h3>
                    <ul class="movie-seances__list">
                        @foreach($seances as $seance)
                            @if ($film['id'] === $seance['film_id'] && $hall['id'] === $seance['hall_id'] && $hall['is_sell_ticket'] === 'true')
                            <li class="movie-seances__time-block" data-time="{{ $seance['time_begin'] }}"><a class="movie-seances__time" href="{{ route('main.show', ['id' => $seance['id']]) }}">{{ $seance['time_begin'] }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </section>
            @endforeach
        </main>
    <script src="js/ConfWeek.js"></script>
    <script src="js/ConfMain.js"></script>
</body>
</html>
