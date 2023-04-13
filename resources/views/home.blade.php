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
        {{--    Для записи в БД новых залов    --}}
        let urlStoreHall = '{{ route('halls.store') }}';
        const csrf_field = '{{ csrf_field() }}';
        const elemBody = document.querySelector('body');
        const buttonCreateHall = document.getElementById('create-hall');
        const elemPopupCreateHall = function(url, csrf_field) {
            return `
                <div class="popup">
                    <div class="popup__container">
                        <div class="popup__content">
                            <div class="popup__header">
                                <h2 class="popup__title">
                                    Добавление зала
                                    <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
                                </h2>
                            </div>
                            <div class="popup__wrapper">
                                <form action="${url}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                    ${csrf_field}
                                    <label class="conf-step__label conf-step__label-fullsize" for="name">Название зала
                                        <input class="conf-step__input" type="text" placeholder="Например, &laquo;Зал 1&raquo;" name="title" required>
                                    </label>
                                    <div class="conf-step__buttons text-center">
                                        <input type="submit" value="Добавить зал" class="conf-step__button conf-step__button-accent">
                                        <button id="cancel-create-hall" class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        buttonCreateHall.addEventListener('click', () => {
            elemBody.insertAdjacentHTML('afterbegin', elemPopupCreateHall(urlStoreHall, csrf_field));
            const elemPopup = document.querySelector('.popup');
            elemPopup.classList.add('active');
            const elemClosePopup = document.querySelector('.popup__dismiss');
            elemClosePopup.addEventListener('click', () => {
                elemPopup.remove('.popup');
            });
            const buttonCancelCreateHall = document.getElementById('cancel-create-hall');
            buttonCancelCreateHall.addEventListener('click', () => {
                elemPopup.remove('.popup');
            });
        });

        {{--    Для удаления залов из БД    --}}
        const halls = document.querySelectorAll('.hall');
        const methodDelete = '{{ method_field('DELETE') }}';
        const elemPopupDeleteHall = function(url, method, csrf_field, title) {
            return `
                <div class="popup">
                    <div class="popup__container">
                        <div class="popup__content">
                            <div class="popup__header">
                                <h2 class="popup__title">
                                    Удаление зала
                                    <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
                                </h2>
                            </div>
                            <div class="popup__wrapper">
                                <form action="${url}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                    ${csrf_field}
                                    ${method}
                                    <p class="conf-step__paragraph">Вы действительно хотите удалить ${title}?</p>
                                    <div class="conf-step__buttons text-center">
                                        <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent">
                                        <button id="cancel-delete-hall" class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        };

        const elemPopupCancelDeleteHall = function(title) {
            return `
                <div class="popup">
                    <div class="popup__container">
                        <div class="popup__content">
                            <div class="popup__header">
                                <h2 class="popup__title">
                                    Удаление зала
                                    <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
                                </h2>
                            </div>
                            <div class="popup__wrapper">
                                <p class="conf-step__paragraph">${title} имеет действующие сеансы. Его нельзя удалять</p>
                                <div class="conf-step__buttons text-center">
                                    <button id="cancel-delete-hall" class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        };

        Array.from(halls).forEach(h => h.addEventListener('click', () => {
            const hallsblock = [];
            let hallblock;

            @foreach($halls as $hall)
                @foreach($seances as $seance)
                    @if ($hall['id'] === $seance['hall_id'])
                        hallblock = hallsblock.find(hb => hb === '{{ $hall['id'] }}');
                        if (!hallblock) {
                            hallsblock.push('{{ $hall['id'] }}');
                        }
                    @endif
                @endforeach
            @endforeach

            const id = h.dataset.id;
            let urlDestroyHall = '{{ route('halls.destroy', ":id") }}';
            urlDestroyHall = urlDestroyHall.replace(':id', id);

            const title = h.closest('li').textContent;
            if (hallsblock.find(hb => hb === id)) {
                elemBody.insertAdjacentHTML('afterbegin', elemPopupCancelDeleteHall(title));
            } else {
                elemBody.insertAdjacentHTML('afterbegin', elemPopupDeleteHall(urlDestroyHall, methodDelete, csrf_field, title));
            }
            const elemPopup = document.querySelector('.popup');
            elemPopup.classList.add('active');
            const elemClosePopup = document.querySelector('.popup__dismiss');
            elemClosePopup.addEventListener('click', () => {
                elemPopup.remove('.popup');
            });
            const buttonCancelDeleteHall = document.getElementById('cancel-delete-hall');
            buttonCancelDeleteHall.addEventListener('click', () => {
                elemPopup.remove('.popup');
            });
        }));

        {{--    Для записи в БД новых фильмов    --}}
        let urlStoreFilm = '{{ route('films.store') }}';
        const buttonAddFilm = document.getElementById('add-film');
        const elemPopupAddFilm = function(url, csrf_field) {
            return `
                <div class="popup">
                    <div class="popup__container">
                        <div class="popup__content">
                            <div class="popup__header">
                                <h2 class="popup__title">
                                    Добавление фильма
                                    <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
                                </h2>
                            </div>
                            <div class="popup__wrapper">
                                <form action="${url}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                    ${csrf_field}
                                    <label class="conf-step__label conf-step__label-fullsize" for="name">Название фильма
                                        <input class="conf-step__input" type="text" placeholder="Например, &laquo;Гражданин Кейн&raquo;" name="title" required>
                                    </label>
                                    <label class="conf-step__label conf-step__label-fullsize" for="name">Продолжительность фильма, мин
                                        <input class="conf-step__input" type="number" min="30" max="220" placeholder="Например, &laquo;90&raquo;" name="duration" required>
                                    </label>
                                    <div class="conf-step__buttons text-center">
                                        <input type="submit" value="Добавить фильм" class="conf-step__button conf-step__button-accent">
                                        <button id="cancel-add-film" class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        buttonAddFilm.addEventListener('click', () => {
            elemBody.insertAdjacentHTML('afterbegin', elemPopupAddFilm(urlStoreFilm, csrf_field));
            const elemPopup = document.querySelector('.popup');
            elemPopup.classList.add('active');
            const elemClosePopup = document.querySelector('.popup__dismiss');
            elemClosePopup.addEventListener('click', () => {
                elemPopup.remove('.popup');
            });
            const buttonCancelAddFilm = document.getElementById('cancel-add-film');
            buttonCancelAddFilm.addEventListener('click', () => {
                elemPopup.remove('.popup');
            });
        });

        {{--    Для удаления фильмов из БД    --}}
        const films = document.querySelectorAll('.film');
        const elemPopupDeleteFilm = function(url, method, csrf_field, title) {
            return `
                <div class="popup">
                    <div class="popup__container">
                        <div class="popup__content">
                            <div class="popup__header">
                                <h2 class="popup__title">
                                    Удаление фильма
                                    <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
                                </h2>
                            </div>
                            <div class="popup__wrapper">
                                <form action="${url}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                    ${csrf_field}
                                    ${method}
                                    <p class="conf-step__paragraph">Вы действительно хотите удалить фильм ${title}?</p>
                                    <div class="conf-step__buttons text-center">
                                        <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent">
                                        <button id="cancel-delete-film" class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        };

        const elemPopupCancelDeleteFilm = function(title) {
            return `
                <div class="popup">
                    <div class="popup__container">
                        <div class="popup__content">
                            <div class="popup__header">
                                <h2 class="popup__title">
                                    Удаление фильма
                                    <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
                                </h2>
                            </div>
                            <div class="popup__wrapper">
                                <p class="conf-step__paragraph">Фильм '${title}' имеет действующие сеансы. Его нельзя удалять</p>
                                <div class="conf-step__buttons text-center">
                                    <button id="cancel-delete-film" class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        };

        Array.from(films).forEach(f => f.addEventListener('click', () => {
            const filmsblock = [];
            let filmblock;

            @foreach($films as $film)
                @foreach($seances as $seance)
                    @if ($film['id'] === $seance['film_id'])
                        filmblock = filmsblock.find(fb => fb === '{{ $film['id'] }}');
                        if (!filmblock) {
                            filmsblock.push('{{ $film['id'] }}');
                        }
                    @endif
                @endforeach
            @endforeach

            const id = f.dataset.id;
            let urlDestroyFilm = '{{ route('films.destroy', ":id") }}';
            urlDestroyFilm = urlDestroyFilm.replace(':id', id);

            const title = f.querySelector('h3').textContent;
            if (filmsblock.find(fb => fb === id)) {
                elemBody.insertAdjacentHTML('afterbegin', elemPopupCancelDeleteFilm(title));
            } else {
                elemBody.insertAdjacentHTML('afterbegin', elemPopupDeleteFilm(urlDestroyFilm, methodDelete, csrf_field, title));
            }

            const elemPopup = document.querySelector('.popup');
            elemPopup.classList.add('active');
            const elemClosePopup = document.querySelector('.popup__dismiss');
            elemClosePopup.addEventListener('click', () => {
                elemPopup.remove('.popup');
            });
            const buttonCancelDeleteFilm = document.getElementById('cancel-delete-film');
            buttonCancelDeleteFilm.addEventListener('click', () => {
                elemPopup.remove('.popup');
            });
        }));

        {{--    Добавление сеансов    --}}
        let urlStoreSeance = '{{ route('seance.store') }}';
        const buttonAddSeance = document.getElementById('add-seance');
        const elemPopupAddSeance = function(url, csrf_field, optionsHalls, optionsFilms) {
            return `
                <div class="popup">
                    <div class="popup__container">
                        <div class="popup__content">
                            <div class="popup__header">
                                <h2 class="popup__title">
                                    Добавление сеанса
                                    <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
                                </h2>
                            </div>
                            <div class="popup__wrapper">
                                <form action="${url}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                    ${csrf_field}
                                    <label class="conf-step__label conf-step__label-fullsize" for="name">Название зала
                                        <select class="conf-step__input" name="hall" required>
                                            ${optionsHalls}
                                        </select>
                                    </label>
                                    <label class="conf-step__label conf-step__label-fullsize" for="name">
                                        Время начала
                                        <input class="conf-step__input" type="time" value="00:00" name="start_time" required>
                                    </label>
                                    <label class="conf-step__label conf-step__label-fullsize" for="name">Название фильма
                                        <select class="conf-step__input" name="film" required>
                                            ${optionsFilms}
                                        </select>
                                    </label>
                                    <input type="hidden" name="types_of_chairs" value="">
                                    <input type="hidden" name="price_of_chair" value="">
                                    <div class="conf-step__buttons text-center">
                                        <input id="send-seance" type="submit" value="Добавить" class="conf-step__button conf-step__button-accent">
                                        <button id="cancel-add-seance" class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        buttonAddSeance.addEventListener('click', () => {
            let optionsFilms = '';
            @if (count($films) > 0)
                @foreach($films as $key => $film)
                    @if ($key !== 0)
                        optionsFilms += '<option data-duration="{{ $film->duration }}" value="{{ $film->id }}">{{ $film->title }}</option>';
                    @else
                        optionsFilms += '<option data-duration="{{ $film->duration }}" value="{{ $film->id }}" selected>{{ $film->title }}</option>';
                    @endif
                @endforeach
            @endif

            let optionsHalls = '';
            @if (count($halls) > 0)
                @foreach($halls as $key => $hall)
                    @if ($key !== 0)
                        optionsHalls += '<option data-types-of-chairs="{{ $hall->types_of_chairs }}" data-price-of-chair="{{ $hall->price_of_chair }}" value="{{ $hall->id }}">{{ $hall->title }}</option>';
                    @else
                        optionsHalls += '<option data-types-of-chairs="{{ $hall->types_of_chairs }}" data-price-of-chair="{{ $hall->price_of_chair }}" value="{{ $hall->id }}" selected>{{ $hall->title }}</option>';
                    @endif
                @endforeach
            @endif

            const netSeances = {};

            @foreach($halls as $hall)
                netSeances['{{ $hall['id'] }}'] = [];
                @foreach($seances as $seance)
                    @if ($hall['id'] === $seance['hall_id'])
                        @foreach($films as $film)
                            @if ($film['id'] === $seance['film_id'])
                                netSeances['{{ $hall['id'] }}'].push({duration: '{{ $film['duration'] }}', timeBegin: '{{ $seance['time_begin'] }}'})
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endforeach

            // for (let i = 0; i < Object.keys(netSeances).length; i++) {
            //     if (Object.values(netSeances)[i].length === 0) {
            //         delete netSeances[Object.keys(netSeances)[i]];
            //     }
            // }

            elemBody.insertAdjacentHTML('afterbegin', elemPopupAddSeance(urlStoreSeance, csrf_field, optionsHalls, optionsFilms));
            const elemPopup = document.querySelector('.popup');
            elemPopup.classList.add('active');
            const elemClosePopup = document.querySelector('.popup__dismiss');
            elemClosePopup.addEventListener('click', () => {
                elemPopup.remove('.popup');
            });
            const buttonCancelAddSeance = document.getElementById('cancel-add-seance');
            buttonCancelAddSeance.addEventListener('click', () => {
                elemPopup.remove('.popup');
            });

            const selectHall = document.querySelector('select[name="hall"]');
            const selectFilm = document.querySelector('select[name="film"]');
            const inputStartTime = document.querySelector('input[name="start_time"]');

            function getAttrSelect(selectHall, selectFilm) {
                const optionHallSelected = selectHall.options[selectHall.selectedIndex];
                const optionFilmSelectedDuration = +selectFilm.options[selectFilm.selectedIndex].dataset.duration;
                const timeBlock = [];
                netSeances[optionHallSelected.value].forEach(a => {
                    const time = a.timeBegin.split(':');
                    const hour = +time[0] * 60;
                    const minute = +time[1];
                    const timeBegin = hour + minute;
                    const timeEnd = timeBegin + +a.duration;
                    for (let i = timeBegin; i <= timeEnd + 10; i++) {
                        timeBlock.push(i);
                    }
                });
                
                const timeNewDurationFilm = [];
                const time = inputStartTime.value.split(':');
                const hour = +time[0] * 60;
                const minute = +time[1];
                const timeBegin = hour + minute;
                const timeEnd = timeBegin + +optionFilmSelectedDuration;
                for (let i = timeBegin; i <= timeEnd + 10; i++) {
                    timeNewDurationFilm.push(i);
                }

                const result = timeNewDurationFilm.some(a => timeBlock.some(arg => arg === a));

                const elemDiv = document.querySelector('.popup .conf-step__buttons');
                const inputSendSeance = document.getElementById('send-seance');
                const messageErrorDuration = '<p id="message-error-duration">* Нельзя создать сеанс с указанными параметрами. Время в зале занято другим фильмом</p>';
                if (result) {
                    if (!document.getElementById('message-error-duration')) {
                        elemDiv.insertAdjacentHTML('beforebegin', messageErrorDuration);
                    }
                    inputSendSeance.disabled = true;
                } else {
                    if (document.getElementById('message-error-duration')) {
                        document.getElementById('message-error-duration').remove();
                    }
                    inputSendSeance.disabled = false;
                }

                const inputTypesOfChairs = document.querySelector('input[name="types_of_chairs"]');
                inputTypesOfChairs.value = optionHallSelected.dataset.typesOfChairs;
                const inputPriceOfChair = document.querySelector('input[name="price_of_chair"]');
                inputPriceOfChair.value = optionHallSelected.dataset.priceOfChair;
            }

            getAttrSelect(selectHall, selectFilm);
            
            selectHall.addEventListener('change', () => {
                getAttrSelect(selectHall, selectFilm);
            });
            selectFilm.addEventListener('change', () => {
                getAttrSelect(selectHall, selectFilm);
            });
            inputStartTime.addEventListener('change', () => {
                getAttrSelect(selectHall, selectFilm);
            });
        });

        {{--    Удаление сеансов    --}}
        const seances = document.querySelectorAll('.conf-step__seances-movie');
        const elemPopupDeleteSeance = function(url, method, csrf_field, title) {
            return `
                <div class="popup">
                    <div class="popup__container">
                        <div class="popup__content">
                            <div class="popup__header">
                                <h2 class="popup__title">
                                    Снятие с сеанса
                                    <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
                                </h2>
                            </div>
                            <div class="popup__wrapper">
                                <form action="${url}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                    ${csrf_field}
                                    ${method}
                                    <p class="conf-step__paragraph">Вы действительно хотите снять с сеанса фильм '${title}'?</p>
                                    <div class="conf-step__buttons text-center">
                                        <input type="submit" value="Снять" class="conf-step__button conf-step__button-accent">
                                        <button id="cancel-delete-seance" class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        };

        const elemPopupCancelDeleteSeance = function(title) {
            return `
                <div class="popup">
                    <div class="popup__container">
                        <div class="popup__content">
                            <div class="popup__header">
                                <h2 class="popup__title">
                                    Снятие с сеанса
                                    <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
                                </h2>
                            </div>
                            <div class="popup__wrapper">
                                <p class="conf-step__paragraph">Продажа билетов на сеанс фильма '${title}' еще идет. Нельзя удалить этот сеанс</p>
                                <div class="conf-step__buttons text-center">
                                    <button id="cancel-delete-seance" class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        };

        Array.from(seances).forEach(s => s.addEventListener('click', () => {
            const seancesBlock = [];

            @foreach($halls as $hall)
                @if ($hall['is_sell_ticket'] === 'true')
                    @foreach($seances as $seance)
                        @if ($hall['id'] === $seance['hall_id'])
                            seancesBlock.push('{{ $seance['id'] }}');
                        @endif
                    @endforeach
                @endif
            @endforeach

            const id = s.dataset.seanceId;
            let urlDestroySeance = '{{ route('seance.destroy', ":id") }}';
            urlDestroySeance = urlDestroySeance.replace(':id', id);
            const title = s.querySelector('.conf-step__seances-movie-title').textContent;

            if (seancesBlock.find(sb => sb === id)) {
                elemBody.insertAdjacentHTML('afterbegin', elemPopupCancelDeleteSeance(title));
            } else {
                elemBody.insertAdjacentHTML('afterbegin', elemPopupDeleteSeance(urlDestroySeance, methodDelete, csrf_field, title));
            }

            const elemPopup = document.querySelector('.popup');
            elemPopup.classList.add('active');
            const elemClosePopup = document.querySelector('.popup__dismiss');
            elemClosePopup.addEventListener('click', () => {
                elemPopup.remove('.popup');
            });
            const buttonCancelDeleteSeance = document.getElementById('cancel-delete-seance');
            buttonCancelDeleteSeance.addEventListener('click', () => {
                elemPopup.remove('.popup');
            });
        }));

    </script>
    <script src="js/ConfHalls.js"></script>
    <script src="js/ConfPriceHalls.js"></script>
    <script src="js/ConfIsSellTicket.js"></script>
    <script src="js/ConfSeances.js"></script>
</div>
@endsection
