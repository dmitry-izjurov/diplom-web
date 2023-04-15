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

    for (let hall of hallsArr) {
        if (!!+hall.is_sell_ticket) {
            for (let seance of seancesArr) {
                if (hall.id === seance.hall_id) {
                    seancesBlock.push(seance.id);
                }
            }
        }
    }

    const id = s.dataset.seanceId;
    let urlDestroySeance = seancesDeleteRouteArr.find(ds => ds.includes(`/delete-seance/${id}`));
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