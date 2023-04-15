@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <header class="page-header">
        <h1 class="page-header__title">Идём<span>в</span>кино</h1>
        <span class="page-header__subtitle">Администраторррская</span>
    </header>
    <main class="conf-steps">
        <section class="conf-step">
            <header class="conf-step__header conf-step__header_opened">
                <h2 class="conf-step__title">Управление залами</h2>
            </header>
            <div class="conf-step__wrapper">
                @if (count($halls) > 0)
                <p class="conf-step__paragraph">Доступные залы:</p>
                <ul class="conf-step__list">
                    @foreach($halls as $hall)
                    <li>{{ $hall->title }}
                        <button data-id="{{ $hall->id }}" class="hall conf-step__button conf-step__button-trash"></button>
                    </li>
                    @endforeach
                </ul>
                @else <p class="conf-step__paragraph">Нет доступных залов</p>
                @endif
                <button id="create-hall" class="conf-step__button conf-step__button-accent">Создать зал</button>
            </div>
        </section>
        <section class="conf-step">
            <header class="conf-step__header conf-step__header_opened">
                <h2 class="conf-step__title">Конфигурация залов</h2>
            </header>
            <div class="conf-step__wrapper">
                @if (count($halls) > 0)
                    <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
                    <ul class="conf-step__selectors-box">
                        @foreach($halls as $key => $hall)
                            @if ($key !== 0)
                                <li class="conf-hall" data-id="{{ $hall->id }}" data-conf-hall="{{ $hall['types_of_chairs'] }}" data-default-conf-hall="{{ $hall['types_of_chairs'] }}">
                                    <input type="radio" class="conf-step__radio" name="chairs-hall" value="{{ $hall['title'] }}">
                                    <span class="conf-step__selector">{{ $hall['title'] }}</span>
                                </li>
                                @else
                                    <li class="conf-hall" data-id="{{ $hall->id }}" data-conf-hall="{{ $hall['types_of_chairs'] }}" data-default-conf-hall="{{ $hall['types_of_chairs'] }}">
                                       <input type="radio" class="conf-step__radio" name="chairs-hall" value="{{ $hall['title'] }}" checked>
                                       <span class="conf-step__selector">{{ $hall['title'] }}</span>
                                    </li>
                            @endif
                        @endforeach
                    </ul>
                    <p class="conf-step__paragraph">Укажите количество рядов и максимальное количество кресел в ряду:</p>
                    <div class="conf-step__legend">
                        <label class="conf-step__label">Рядов, шт
                            <input id="input-rows" type="number" class="conf-step__input" placeholder="10">
                        </label>
                        <span class="multiplier">x</span>
                        <label class="conf-step__label">Мест, шт
                            <input id="input-chairs" type="number" class="conf-step__input" placeholder="8">
                        </label>
                    </div>
                    <p class="conf-step__paragraph">Теперь вы можете указать типы кресел на схеме зала:</p>
                    <div class="conf-step__legend">
                        <span class="conf-step__chair conf-step__chair_standart"></span> — обычные кресла
                        <span class="conf-step__chair conf-step__chair_vip"></span> — VIP кресла
                        <span class="conf-step__chair conf-step__chair_disabled"></span> — заблокированные (нет кресла)
                        <p class="conf-step__hint">Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши</p>
                    </div>
                <div class="conf-step__hall"></div>
                <fieldset class="conf-step__buttons text-center">
                    <form name="form-types_of_chairs" action="{{ route('halls.update') }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <button id="cancel-button-hall" class="conf-step__button conf-step__button-regular" type="button">Отмена</button>
                        <input id="save-button-conf-hall" type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
                        <div>
                            <input type="hidden" name="types_of_chairs" value="">
                        </div>
                    </form>
                </fieldset>
                    @else <p class="conf-step__paragraph">Нет доступных залов</p>
                @endif
            </div>
        </section>

        <section class="conf-step">
            <header class="conf-step__header conf-step__header_opened">
                <h2 class="conf-step__title">Конфигурация цен</h2>
            </header>
            <div class="conf-step__wrapper">

                @if (count($halls) > 0)
                <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
                <ul class="conf-step__selectors-box">
                    @foreach($halls as $key => $hall)
                        @if ($key !== 0)
                            <li class="conf-hall_price" data-id="{{ $hall->id }}" data-price-chair="{{ $hall['price_of_chair'] }}" data-default-price-chair="{{ $hall['price_of_chair'] }}">
                                <input type="radio" class="conf-step__radio" name="prices-hall" value="{{ $hall['title'] }}">
                                <span class="conf-step__selector">{{ $hall['title'] }}</span>
                            </li>
                        @else
                        <li class="conf-hall_price" data-id="{{ $hall->id }}" data-price-chair="{{ $hall['price_of_chair'] }}" data-default-price-chair="{{ $hall['price_of_chair'] }}">
                            <input type="radio" class="conf-step__radio" name="prices-hall" value="{{ $hall['title'] }}" checked>
                            <span class="conf-step__selector">{{ $hall['title'] }}</span>
                        </li>
                        @endif
                    @endforeach
                </ul>
                @else <p class="conf-step__paragraph">Нет доступных залов</p>
            @endif

                <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
                <div class="conf-step__legend">
                    <label class="conf-step__label">Цена, рублей
                        <input id="input-st-chair" type="number" class="conf-step__input" placeholder="0">
                    </label>
                    за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
                </div>
                <div class="conf-step__legend">
                    <label class="conf-step__label">Цена, рублей
                        <input id="input-vip-chair" type="number" class="conf-step__input" placeholder="0">
                    </label>
                    за <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
                </div>

                <fieldset class="conf-step__buttons text-center">
                    <form name="form-price_of_chair" action="{{ route('halls.update') }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <button id="cancel-button-hall-price" type="button" class="conf-step__button conf-step__button-regular">Отмена</button>
                        <input id="save-button-conf-hall-price" type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
                        <div>
                            <input type="hidden" name="price_of_chair" value="">
                        </div>
                    </form>
                </fieldset>
            </div>
        </section>

        <section class="conf-step">
            <header class="conf-step__header conf-step__header_opened">
                <h2 class="conf-step__title">Сетка сеансов</h2>
            </header>
            <div class="conf-step__wrapper">
                <p class="conf-step__paragraph">
                    <button id="add-film" class="conf-step__button conf-step__button-accent">Добавить фильм</button>
                </p>

                <div class="conf-step__movies">
                @if (count($films) > 0)
                    @foreach($films as $film)
                    <div data-id="{{ $film->id }}" class="film conf-step__movie">
                        <img class="conf-step__movie-poster" alt="poster" src="i/poster.png">
                        <h3 class="conf-step__movie-title">{{ $film['title'] }}</h3>
                        <p class="conf-step__movie-duration">{{ $film['duration'] }} минут</p>
                    </div>
                    @endforeach
                @else <p class="conf-step__paragraph">Нет доступных фильмов</p>
                @endif
                </div>
                <p class="conf-step__paragraph">
                    <button id="add-seance" class="conf-step__button conf-step__button-accent">Добавить сеанс</button>
                </p>
                <div class="conf-step__seances">
                    @if (count($seances) > 0)
                        @foreach($halls as $hall)
                        <div class="conf-step__seances-hall" data-hall-id="{{ $hall['id'] }}">
                            <h3 class="conf-step__seances-title">{{ $hall['title'] }}</h3>
                            <div class="conf-step__seances-timeline">
                                @foreach($seances as $seance)
                                    @if ($seance['hall_id'] === $hall['id'])  
                                        @foreach($films as $film)
                                            @if ($film['id'] === $seance['film_id'])
                                            <div class="conf-step__seances-movie" data-seance-id="{{ $seance['id'] }}" data-film-duration="{{ $film['duration'] }}" data-seance-time-begin="{{ $seance['time_begin'] }}">
                                                <p class="conf-step__seances-movie-title">{{ $film['title'] }}</p>
                                                <p class="conf-step__seances-movie-start">{{ $seance['time_begin'] }}</p>
                                            </div>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    @else <p class="conf-step__paragraph">Нет доступных сеансов</p>
                    @endif
                </div>
            </div>
        </section>

        <section class="conf-step">
            <header class="conf-step__header conf-step__header_opened">
                <h2 class="conf-step__title">Открыть продажи</h2>
            </header>
            <div class="conf-step__wrapper text-center">
                @if (count($halls) > 0)
                    <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
                    <ul class="conf-step__selectors-box">
                        @foreach($halls as $key => $hall)
                            @if ($key !== 0)
                                <li class="conf-hall_sell" data-id="{{ $hall->id }}" data-conf-hall-sell="{{ $hall['is_sell_ticket'] }}">
                                    <input type="radio" class="conf-step__radio" name="sale-hall" value="{{ $hall['title'] }}">
                                    <span class="conf-step__selector">{{ $hall['title'] }}</span>
                                </li>
                                @else
                                    <li class="conf-hall_sell" data-id="{{ $hall->id }}" data-conf-hall-sell="{{ $hall['is_sell_ticket'] }}">
                                       <input type="radio" class="conf-step__radio" name="sale-hall" value="{{ $hall['title'] }}" checked>
                                       <span class="conf-step__selector">{{ $hall['title'] }}</span>
                                    </li>
                            @endif
                        @endforeach
                    </ul>
                    <p class="conf-step__paragraph">Всё готово, теперь можно:</p>
                    <form name="form-is_sell_ticket" action="{{ route('halls.update') }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="is_sell_ticket" value="">
                    </form>
                    
                    @else <p class="conf-step__paragraph">Нет доступных залов</p>
                @endif
            </div>
        </section>
    </main>
    <script src="js/accordeon.js"></script>
    <script>
        var urlStoreHall = '{{ route('halls.store') }}';
        var methodDelete = '{{ method_field('DELETE') }}';
        let urlDestroyHall = '{{ route('halls.destroy', ":id") }}';
        let urlDestroyFilm = '{{ route('films.destroy', ":id") }}';
        let urlDestroySeance = '{{ route('seance.destroy', ":id") }}';
        var urlStoreFilm = '{{ route('films.store') }}';
        var urlStoreSeance = '{{ route('seance.store') }}';
        var csrf_field = '{{ csrf_field() }}';
        var hallsArr = [];
        var hallsDeleteRouteArr = [];
        var filmsDeleteRouteArr = [];
        var seancesDeleteRouteArr = [];
        var filmsArr = [];
        var seancesArr = [];

        @foreach($halls as $hall)
            hallsDeleteRouteArr.push(urlDestroyHall.replace(':id', '{{ $hall['id'] }}'));
            hallsArr.push({
                id: '{{ $hall['id'] }}',
                title: '{{ $hall['title'] }}',
                is_sell_ticket: '{{ $hall['is_sell_ticket'] }}',
                types_of_chairs: '{{ $hall['types_of_chairs'] }}',
                price_of_chair: '{{ $hall['price_of_chair'] }}'});
        @endforeach

        @foreach($films as $film)
            filmsDeleteRouteArr.push(urlDestroyFilm.replace(':id', '{{ $film['id'] }}'));
            filmsArr.push({
                id: '{{ $film['id'] }}',
                title: '{{ $film['title'] }}',
                duration: '{{ $film['duration'] }}'});
        @endforeach

        @foreach($seances as $seance)
            seancesDeleteRouteArr.push(urlDestroySeance.replace(':id', '{{ $seance['id'] }}'));
            seancesArr.push({
                id: '{{ $seance['id'] }}',
                time_begin: '{{ $seance['time_begin'] }}',
                film_id: '{{ $seance['film_id'] }}',
                hall_id: '{{ $seance['hall_id'] }}',
                types_of_chairs: '{{ $seance['types_of_chairs'] }}',
                price_of_chair: '{{ $seance['price_of_chair'] }}'});
        @endforeach

    </script>
    <script src="js/createHall.js"></script>
    <script src="js/deleteHall.js"></script>
    <script src="js/createFilm.js"></script>
    <script src="js/deleteFilm.js"></script>
    <script src="js/createSeance.js"></script>
    <script src="js/deleteSeance.js"></script>
    <script src="js/ConfHalls.js"></script>
    <script src="js/ConfPriceHalls.js"></script>
    <script src="js/ConfIsSellTicket.js"></script>
    <script src="js/ConfSeances.js"></script>
</div>
@endsection
