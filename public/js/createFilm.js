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
                                <input class="conf-step__input" maxlength="60" type="text" placeholder="Например, &laquo;Гражданин Кейн&raquo;" name="title" required>
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