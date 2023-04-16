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
        <section class="ticket">
            <header class="tichet__check">
                <h2 class="ticket__check-title">Вы выбрали билеты:</h2>
            </header>
            <div class="ticket__info-wrapper" data-film="{{ $film }}" data-chairs="{{ $chairs }}" data-hall="{{ $hall }}" data-start="{{ $seance['time_begin'] }}">
                <p class="ticket__info">На фильм: <span class="ticket__details ticket__title">{{ $film }}</span></p>
                <p class="ticket__info">Места: <span class="ticket__details ticket__chairs">{{ $chairs }}</span></p>
                <p class="ticket__info">В зале: <span class="ticket__details ticket__hall">{{ $hall }}</span></p>
                <p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start">{{ $seance['time_begin'] }}</span></p>
                <p id="ticket-info" class="ticket__info">Стоимость: <span class="ticket__details ticket__cost">{{ $cost }}</span> рублей</p>
                <div class="qrcode-wrapper"><div id="qrcode"></div></div>
                <button class="acceptin-button" type="button">Получить код бронирования</button>
                <p id="ticket-hint" class="ticket__hint">После оплаты билет будет доступен в этом окне, а также придёт вам на почту. Покажите QR-код нашему контроллёру у входа в зал.</p>
                <p class="ticket__hint">Приятного просмотра!</p>
            </div>
        </section>
    </main>
    <div class="block__link-main">
        <a class="link-main" href="{{ route('main.index') }}">На главную</a>
    </div>
    <script src="../../js/qrcode.js"></script>
    <script src="../../js/ConfPayment.js"></script>
</body>
</html>