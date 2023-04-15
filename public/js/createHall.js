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
                                <input class="conf-step__input" maxlength="30" type="text" placeholder="Например, &laquo;Зал 1&raquo;" name="title" required>
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