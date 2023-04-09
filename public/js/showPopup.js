const elemBody = document.querySelector('body');
const buttonCreateHall = document.getElementById('create-hall');
const halls = document.querySelectorAll('.hall');
const elemPopupCreateHall = function(url,) {
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

const elemPopupDeleteHall = function(id, title) {
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
                        <form action="{{ route('halls.destroy', ['id' => ${id}]) }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <?php
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        ?>
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

buttonCreateHall.addEventListener('click', () => {
    const url = buttonCreateHall.dataset.url;
    elemBody.insertAdjacentHTML('afterbegin', elemPopupCreateHall(url));
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

Array.from(halls).forEach(h => h.addEventListener('click', () => {
    const id = h.dataset.id;
    const title = h.closest('li').textContent;
    elemBody.insertAdjacentHTML('afterbegin', elemPopupDeleteHall(id, title));
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

// onclick="
//                     const elemPopup = document.querySelector('.popup');
//                     elemPopup.classList.add('active');
//                     const elemClosePopup = document.querySelector('.popup__dismiss');
//                     elemClosePopup.addEventListener('click', () => {
//                         elemPopup.classList.remove('active');
//                     });
//                     const buttonCancelCreateHall = document.getElementById('cancel-create-hall');
//                     buttonCancelCreateHall.addEventListener('click', () => {
//                         elemPopup.classList.remove('active');
//                     });
//                 "
