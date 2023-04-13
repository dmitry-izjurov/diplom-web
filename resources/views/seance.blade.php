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
    <main>
        <section class="buying">
            <div class="buying__info">
                <div class="buying__info-description">
                    @foreach($films as $film)
                        @if ($film['id'] === $seance['film_id'])
                        <h2 data-film="{{ $film['title'] }}" class="buying__info-title">{{ $film['title'] }}</h2>
                        @endif
                    @endforeach
                    <p class="buying__info-start">Начало сеанса: {{ $seance['time_begin'] }}</p>
                    @foreach($halls as $hall)
                        @if ($hall['id'] === $seance['hall_id'])
                        <p data-hall="{{ $hall['title'] }}" class="buying__info-hall">{{ $hall['title'] }}</p>
                        @endif
                    @endforeach
                </div>
                <div class="buying__info-hint">
                    <p>Тапните дважды,<br>чтобы увеличить</p>
                </div>
            </div>
            <div class="buying-scheme" data-id="{{ $seance['id'] }}" data-conf-hall="{{ $seance['types_of_chairs'] }}" data-price-chair="{{ $seance['price_of_chair'] }}">
                <div class="buying-scheme__legend">
                    <div class="col">
                        <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_standart"></span> Свободно (<span id="price-st" class="buying-scheme__legend-value"></span> руб)</p>
                        <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_vip"></span> Свободно VIP (<span id="price-vip" class="buying-scheme__legend-value"></span> руб)</p>            
                    </div>
                    <div class="col">
                        <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_taken"></span> Занято</p>
                        <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_selected"></span> Выбрано</p>                    
                    </div>
                </div>
            </div>
            <form name="form-types_of_chairs" action="{{ route('main.update', ['id' => $seance->id]) }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div>
                    <input type="hidden" name="types_of_chairs" value="">
                    <input type="hidden" name="selected_chairs" value="">
                    <input type="hidden" name="cost" value="">
                    <input type="hidden" name="hall" value="">
                    <input type="hidden" name="film" value="">
                </div>
                <button class="acceptin-button">Забронировать</button>
            </form>
        </section>     
    </main>
    <div class="block__link-main">
        <a class="link-main" href="{{ route('main.index') }}">На главную</a>
    </div>
    <script src="../js/ConfHallSeances.js"></script>
</body>
</html>