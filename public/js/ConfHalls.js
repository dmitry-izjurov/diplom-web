class ConfHall {
    constructor() {
        this.confHalls = document.querySelectorAll('.conf-hall');                       // все залы
        this.initElemConfHalls = this.confHalls.item(0);                                // первый зал из базы данных и последующий при клике
        this.elemConfStepHall = document.querySelector('.conf-step__hall');             // секция для кресел
        this.elemInputRows = document.getElementById('input-rows');                     // инпут для ввода количества рядов
        this.elemInputChairs = document.getElementById('input-chairs');                 // инпут для ввода количества кресел
        this.chairs;                                                                    // все кресла (включая отсутствующие)
        this.elemInputRowsValueOld = 0;                                                 // предыдущее значение количества рядов
        this.elemInputChairsValueOld = 0;                                               // предыдущее значение количества кресел
        this.confHallArr = [];                                                          // все кресла в залах в массиве данных
    }

    init() {
        const confHall = this.initElemConfHalls.dataset.confHall;
        this.getValuesHall(confHall);
        
        Array.from(this.confHalls).forEach(h => h.addEventListener('click', () => {
            if (this.initElemConfHalls !== h) {
                this.initElemConfHalls = h;
                const confHall = h.dataset.confHall;
                document.querySelector('.conf-step__hall-wrapper').remove();
                this.getValuesHall(confHall);
                this.installHandlerOnChairs();
                this.getDefaultStateHall(this.initElemConfHalls);
            }
        }));

        this.installHandlerOnChairs();
        this.getDefaultStateHall(this.initElemConfHalls);

        this.elemInputRows.addEventListener('change', () => {
            if (Number.isNaN(+this.elemInputRows.value)) {
                this.elemInputRows.value = 10;
            } else if (+this.elemInputRows.value < 4) {
                this.elemInputRows.value = 4;
            } else if (+this.elemInputRows.value > 10) {
                this.elemInputRows.value = 10;
            }

            if (+this.elemInputRows.value > this.elemInputRowsValueOld) {
                const diff = +this.elemInputRows.value - this.confHallArr.length;
                const arrChairsStandart = [];
                for (let i = 0; i < +this.elemInputChairs.value; i++) {
                    arrChairsStandart.push('s');
                }
                for (let i = 0; i < diff; i++) {
                    this.confHallArr.push(arrChairsStandart);
                }
                document.querySelector('.conf-step__hall-wrapper').remove();
                const dataAttrConfHall = this.getArrToStr(this.confHallArr);
                this.getValuesHall(dataAttrConfHall);
                this.initElemConfHalls.dataset.confHall = dataAttrConfHall; 
                this.installHandlerOnChairs();               
            } else if (+this.elemInputRows.value < this.elemInputRowsValueOld) {
                const arr = [];
                for (let i = 0; i < +this.elemInputRows.value; i++) {
                    arr.push(this.confHallArr[i]);
                }
                document.querySelector('.conf-step__hall-wrapper').remove();
                const dataAttrConfHall = this.getArrToStr(arr);
                this.getValuesHall(dataAttrConfHall);
                this.initElemConfHalls.dataset.confHall = dataAttrConfHall;
                this.installHandlerOnChairs();
            }
            this.elemInputRowsValueOld = +this.elemInputRows.value;
        });

        this.elemInputChairs.addEventListener('change', () => {
            let arr = [];
            if (Number.isNaN(+this.elemInputChairs.value)) {
                this.elemInputChairs.value = 8;
            } else if (+this.elemInputChairs.value < 3) {
                this.elemInputChairs.value = 3;
            } else if (+this.elemInputChairs.value > 20) {
                this.elemInputChairs.value = 20;
            }

            if (+this.elemInputChairs.value > this.elemInputChairsValueOld) {
                const diff = +this.elemInputChairs.value - this.confHallArr[0].length;
                arr = this.confHallArr;
                arr.forEach(arg => {
                    for (let i = 0; i < diff; i++) {
                        arg.push('s');
                    }
                });
                document.querySelector('.conf-step__hall-wrapper').remove();
                const dataAttrConfHall = this.getArrToStr(arr);
                this.getValuesHall(dataAttrConfHall);
                this.initElemConfHalls.dataset.confHall = dataAttrConfHall;
                this.installHandlerOnChairs();
            } else if (+this.elemInputChairs.value < this.elemInputChairsValueOld) {
                this.confHallArr.forEach(arg => {
                    const arrChairs = [];
                    for (let i = 0; i < +this.elemInputChairs.value; i++) {
                        arrChairs.push(arg[i]);
                    }
                    arr.push(arrChairs);
                });
                document.querySelector('.conf-step__hall-wrapper').remove();
                const dataAttrConfHall = this.getArrToStr(arr);
                this.getValuesHall(dataAttrConfHall);
                this.initElemConfHalls.dataset.confHall = dataAttrConfHall;
                this.installHandlerOnChairs();
            }
            this.elemInputChairsValueOld = +this.elemInputChairs.value;
        });

        // Форма для отправки обновлённой конфигурации кинотеатров
        const formTypesOfChairs = document.querySelector('form[name="form-types_of_chairs"]');
        formTypesOfChairs.addEventListener('submit', () => {
            const inputTypesOfChairs = formTypesOfChairs.querySelector('input[name="types_of_chairs"]');
            let strDataTypesOfChairs = '';
            this.confHalls.forEach((h,i,arr) => {
                strDataTypesOfChairs += h.dataset.id + '=' + h.dataset.confHall;
                if (i !== arr.length - 1) {
                    strDataTypesOfChairs += '-';
                }
            });

            inputTypesOfChairs.value = strDataTypesOfChairs;
        });
    }

    getValuesHall(confHall) {
        this.confHallArr = [];
        confHall.split('|').forEach(a => this.confHallArr.push(a.split(',')));
        this.elemConfStepHall.insertAdjacentHTML('afterbegin', this.getConfHall(this.confHallArr));
        this.elemInputRows.value = this.getRows(this.confHallArr);
        this.elemInputRowsValueOld = +this.elemInputRows.value;
        this.elemInputChairs.value = this.getChairs(this.confHallArr);
        this.elemInputChairsValueOld = +this.elemInputChairs.value;
    }

    getConfHall(arrConfHall) {
        let strHTMLHall = '<div class="conf-step__hall-wrapper">';
        arrConfHall.forEach((row) => {
            strHTMLHall += '<div class="conf-step__row">';
            row.forEach((arg) => {
                switch (arg) {
                    case 'd':
                        strHTMLHall += '<span class="conf-step__chair conf-step__chair_disabled"></span>';
                        break;
                    case 's':
                        strHTMLHall += '<span class="conf-step__chair conf-step__chair_standart"></span>';
                        break;
                    case 'v':
                        strHTMLHall += '<span class="conf-step__chair conf-step__chair_vip"></span>';
                        break;
                }
            });
            strHTMLHall += '</div>';
        });
        strHTMLHall += '</div>';

        return strHTMLHall;
    }

    getArrToStr(arr) {
        let result = '';
        arr.map(arg => arg.join(',')).forEach((a, i, initArr) => {
            result += a;
            if (i !== initArr.length - 1) {
                result += '|';
            }
        });
        return result;        
    }

    getRows(arrConfHall) {
        return arrConfHall.length;
    }
    
    getChairs(arrConfHall) {
        return arrConfHall[0].length;
    }

    renameClassName(elem) {
        if (elem.classList.contains('conf-step__chair_disabled')) {
            elem.classList.remove('conf-step__chair_disabled');
            elem.classList.add('conf-step__chair_standart');
        } else if (elem.classList.contains('conf-step__chair_standart')) {
            elem.classList.remove('conf-step__chair_standart');
            elem.classList.add('conf-step__chair_vip');
        } else if (elem.classList.contains('conf-step__chair_vip')) {
            elem.classList.remove('conf-step__chair_vip');
            elem.classList.add('conf-step__chair_disabled');
        }
    }

    findIndexConfHallArr(i) {
        return [Math.floor(i / +this.elemInputChairs.value), i - Math.floor(i / +this.elemInputChairs.value) * +this.elemInputChairs.value]
    }

    installHandlerOnChairs() {
        this.chairs = document.querySelectorAll('.conf-step__row .conf-step__chair');
        Array.from(this.chairs).forEach((c,i) => c.addEventListener('click', () => {
            this.renameClassName(c);
            const index = this.findIndexConfHallArr(i);
            let stateChair = '';
            if (c.classList.contains('conf-step__chair_disabled')) {
                stateChair = 'd';
            } else if (c.classList.contains('conf-step__chair_standart')) {
                stateChair = 's';
            } else if (c.classList.contains('conf-step__chair_vip')) {
                stateChair = 'v';
            }
            this.confHallArr[index[0]][index[1]] = stateChair;
            const dataAttrConfHall = this.getArrToStr(this.confHallArr);
            this.initElemConfHalls.dataset.confHall = dataAttrConfHall;
        }));
    }

    getDefaultStateHall(hall) {
        const htmlButtonCancelHall = `
            <button id="cancel-button-hall" class="conf-step__button conf-step__button-regular" type="button">Отмена</button>
        `;
        document.getElementById('cancel-button-hall').remove();
        document.getElementById('save-button-conf-hall').insertAdjacentHTML('beforebegin', htmlButtonCancelHall);
        const buttonCancelHall = document.getElementById('cancel-button-hall');
        buttonCancelHall.addEventListener('click', () => {
            document.querySelector('.conf-step__hall-wrapper').remove();
            const confHallDefaultValue = hall.dataset.defaultConfHall;
            this.getValuesHall(confHallDefaultValue);
            hall.dataset.confHall = confHallDefaultValue;
            this.installHandlerOnChairs();
        });
    }
}

const confHall = new ConfHall();
confHall.init();
