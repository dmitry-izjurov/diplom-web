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
    if (filmsArr.length > 0) {
        for (let i = 0; i < filmsArr.length; i++) {
            if (i !== 0) {
                optionsFilms += `<option data-duration="${filmsArr[i].duration}" value="${filmsArr[i].id}">${filmsArr[i].title}</option>`;
            } else {
                optionsFilms += `<option data-duration="${filmsArr[i].duration}" value="${filmsArr[i].id}" selected>${filmsArr[i].title}</option>`;
            }
        }
    }

    let optionsHalls = '';

    if (hallsArr.length > 0) {
        for (let i = 0; i < hallsArr.length; i++) {
            if (i !== 0) {
                optionsHalls += `<option data-types-of-chairs="${hallsArr[i].types_of_chairs}" data-price-of-chair="${hallsArr[i].price_of_chair}" value="${hallsArr[i].id}">${hallsArr[i].title}</option>`;
            } else {
                optionsHalls += `<option data-types-of-chairs="${hallsArr[i].types_of_chairs}" data-price-of-chair="${hallsArr[i].price_of_chair}" value="${hallsArr[i].id}" selected>${hallsArr[i].title}</option>`;
            }
        }
    }

    const netSeances = {};

    for (let hall of hallsArr) {
        netSeances[hall.id] = [];
        for (let seance of seancesArr) {
            if (hall.id === seance.hall_id) {
                for (let film of filmsArr) {
                    if (film.id === seance.film_id) {
                        netSeances[hall.id].push({duration: film.duration, timeBegin: seance.time_begin});
                    }
                }
            }
        }
    }

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