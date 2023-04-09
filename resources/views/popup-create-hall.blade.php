@extends('home')

@section('popup-create-hall')
<div class="popup active">
    <div class="popup__container">
        <div class="popup__content">
            <div class="popup__header">
                <h2 class="popup__title">
                    Добавление зала
                    <a class="popup__dismiss" href="{{ route('halls.index') }}"><img src="i/close.png" alt="Закрыть"></a>
                </h2>
            </div>
            <div class="popup__wrapper">
                <form action="{{ route('halls.store') }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <label class="conf-step__label conf-step__label-fullsize" for="name">Название зала
                        <input class="conf-step__input" type="text" placeholder="Например, &laquo;Зал 1&raquo;" name="title" required>
                    </label>
                    <div class="conf-step__buttons text-center">
                        <input id="add-create-hall" type="submit" value="Добавить зал" class="conf-step__button conf-step__button-accent">
                        <a id="cancel-create-hall" class="conf-step__button conf-step__button-regular" href="{{ route('halls.index') }}">Отменить</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
