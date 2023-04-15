const halls = document.querySelectorAll('.hall');
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

    for (let hall of hallsArr) {
        for (let seance of seancesArr) {
            if (hall.id === seance.hall_id) {
                hallblock = hallsblock.find(hb => hb === hall.id);
                if (!hallblock) {
                    hallsblock.push(hall.id);
                }
            }
        }
    }

    const id = h.dataset.id;
    let urlDestroyHall = hallsDeleteRouteArr.find(dh => dh.includes(`/delete-hall/${id}`));

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