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
                            <input id="input-rows" type="text" class="conf-step__input" placeholder="10">
                        </label>
                        <span class="multiplier">x</span>
                        <label class="conf-step__label">Мест, шт
                            <input id="input-chairs" type="text" class="conf-step__input" placeholder="8">
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
                        <input id="input-st-chair" type="text" class="conf-step__input" placeholder="0">
                    </label>
                    за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
                </div>
                <div class="conf-step__legend">
                    <label class="conf-step__label">Цена, рублей
                        <input id="input-vip-chair" type="text" class="conf-step__input" placeholder="0">
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
                    <button class="conf-step__button conf-step__button-accent">Добавить фильм</button>
                </p>
                <div class="conf-step__movies">
                    <div class="conf-step__movie">
                        <img class="conf-step__movie-poster" alt="poster" src="i/poster.png">
                        <h3 class="conf-step__movie-title">Звёздные войны XXIII: Атака клонированных клонов</h3>
                        <p class="conf-step__movie-duration">130 минут</p>
                    </div>

                    <div class="conf-step__movie">
                        <img class="conf-step__movie-poster" alt="poster" src="i/poster.png">
                        <h3 class="conf-step__movie-title">Миссия выполнима</h3>
                        <p class="conf-step__movie-duration">120 минут</p>
                    </div>

                    <div class="conf-step__movie">
                        <img class="conf-step__movie-poster" alt="poster" src="i/poster.png">
                        <h3 class="conf-step__movie-title">Серая пантера</h3>
                        <p class="conf-step__movie-duration">90 минут</p>
                    </div>

                    <div class="conf-step__movie">
                        <img class="conf-step__movie-poster" alt="poster" src="i/poster.png">
                        <h3 class="conf-step__movie-title">Движение вбок</h3>
                        <p class="conf-step__movie-duration">95 минут</p>
                    </div>

                    <div class="conf-step__movie">
                        <img class="conf-step__movie-poster" alt="poster" src="i/poster.png">
                        <h3 class="conf-step__movie-title">Кот Да Винчи</h3>
                        <p class="conf-step__movie-duration">100 минут</p>
                    </div>
                </div>

                <div class="conf-step__seances">
                    <div class="conf-step__seances-hall">
                        <h3 class="conf-step__seances-title">Зал 1</h3>
                        <div class="conf-step__seances-timeline">
                            <div class="conf-step__seances-movie" style="width: 60px; background-color: rgb(133, 255, 137); left: 0;">
                                <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                                <p class="conf-step__seances-movie-start">00:00</p>
                            </div>
                            <div class="conf-step__seances-movie" style="width: 60px; background-color: rgb(133, 255, 137); left: 360px;">
                                <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                                <p class="conf-step__seances-movie-start">12:00</p>
                            </div>
                            <div class="conf-step__seances-movie" style="width: 65px; background-color: rgb(202, 255, 133); left: 420px;">
                                <p class="conf-step__seances-movie-title">Звёздные войны XXIII: Атака клонированных клонов</p>
                                <p class="conf-step__seances-movie-start">14:00</p>
                            </div>
                        </div>
                    </div>
                    <div class="conf-step__seances-hall">
                        <h3 class="conf-step__seances-title">Зал 2</h3>
                        <div class="conf-step__seances-timeline">
                            <div class="conf-step__seances-movie" style="width: 65px; background-color: rgb(202, 255, 133); left: 595px;">
                                <p class="conf-step__seances-movie-title">Звёздные войны XXIII: Атака клонированных клонов</p>
                                <p class="conf-step__seances-movie-start">19:50</p>
                            </div>
                            <div class="conf-step__seances-movie" style="width: 60px; background-color: rgb(133, 255, 137); left: 660px;">
                                <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                                <p class="conf-step__seances-movie-start">22:00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <fieldset class="conf-step__buttons text-center">
                    <button class="conf-step__button conf-step__button-regular">Отмена</button>
                    <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
                </fieldset>
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
                                <li>
                                    <input type="radio" class="conf-step__radio" name="sale-hall" value="{{ $hall['title'] }}">
                                    <span class="conf-step__selector">{{ $hall['title'] }}</span>
                                </li>
                                @else
                                    <li>
                                       <input type="radio" class="conf-step__radio" name="sale-hall" value="{{ $hall['title'] }}" checked>
                                       <span class="conf-step__selector">{{ $hall['title'] }}</span>
                                    </li>
                            @endif
                        @endforeach
                    </ul>
                    <p class="conf-step__paragraph">Всё готово, теперь можно:</p>
                    <button class="conf-step__button conf-step__button-accent">Открыть продажу билетов</button>
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

        {{--    Для удаления из БД  залов    --}}
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

        Array.from(halls).forEach(h => h.addEventListener('click', () => {
            const id = h.dataset.id;
            let urlDestroyHall = '{{ route('halls.destroy', ":id") }}';
            urlDestroyHall = urlDestroyHall.replace(':id', id);

            const title = h.closest('li').textContent;
            elemBody.insertAdjacentHTML('afterbegin', elemPopupDeleteHall(urlDestroyHall, methodDelete, csrf_field, title));
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
    </script>
    <script src="js/ConfHalls.js"></script>
    <script src="js/ConfPriceHalls.js"></script>
</div>
@endsection
