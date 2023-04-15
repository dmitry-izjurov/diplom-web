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

    for (let film of filmsArr) {
        for (let seance of seancesArr) {
            if (film.id === seance.film_id) {
                        filmblock = filmsblock.find(fb => fb === film.id);
                if (!filmblock) {
                    filmsblock.push(film.id);
                }
            }
        }
    }

    const id = f.dataset.id;
    let urlDestroyFilm = filmsDeleteRouteArr.find(df => df.includes(`/delete-film/${id}`));

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