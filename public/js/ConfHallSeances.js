class ConfHallSeances {
    constructor() {
        this.confHall = document.querySelector('.buying-scheme');                       // зал
        this.elemConfStepHall = document.querySelector('.buying-scheme');               // секция для кресел
        this.confHallArr = [];                                                          // все кресла в залах в массиве данных
        this.chairs;                                                                    // все кресла (включая отсутствующие)
        this.quantityChairsInRow = 0;                                                   // количество кресел в ряду
        this.selectedChairs = [];                                                       // выбранные кресла
        this.selectedChairsStr = '';                                                    // выбранные кресла с номерами строкой 
        this.confPriceHallsArr = {};                                                    // все цены на кресла
        this.cost = 0;                                                                  // общая стоимость за билеты
        this.hall = document.querySelector('.buying__info-hall').dataset.hall;          // Название зала
        this.film = document.querySelector('.buying__info-title').dataset.film;         // Название фильма
    }

    init() {
        const confHall = this.confHall.dataset.confHall;
        const confPriceHall = this.confHall.dataset.priceChair;
        this.getValuesHall(confHall);
        this.installHandlerOnChairs();
        this.getObjStr(confPriceHall);
        document.getElementById('price-st').textContent = this.confPriceHallsArr.standart;
        document.getElementById('price-vip').textContent = this.confPriceHallsArr.vip;
        document.querySelector('input[name="hall"]').value = this.hall;
        document.querySelector('input[name="film"]').value = this.film;

        const formTypesOfChairs = document.querySelector('form[name="form-types_of_chairs"]');
        formTypesOfChairs.addEventListener('submit', (e) => {
            const inputTypesOfChairs = formTypesOfChairs.querySelector('input[name="types_of_chairs"]');
            
            if (confHall !== this.confHall.dataset.confHall) {
                this.confHallArr.forEach((arr,ind) => arr.forEach((a,i) => a === 'sl' ? this.confHallArr[ind][i] = 't' : undefined));
                let strDataTypesOfChairs = this.getArrToStr(this.confHallArr);
                inputTypesOfChairs.value = strDataTypesOfChairs;
            } else {
                inputTypesOfChairs.value = '';
                e.preventDefault();
            }
        });
    }

    getValuesHall(confHall) {
        this.confHallArr = [];
        confHall.split('|').forEach(a => this.confHallArr.push(a.split(',')));
        this.quantityChairsInRow = this.confHallArr[0].length;
        this.elemConfStepHall.insertAdjacentHTML('afterbegin', this.getConfHall(this.confHallArr));
    }

    getConfHall(arrConfHall) {
        let strHTMLHall = '<div class="buying-scheme__wrapper">';
        arrConfHall.forEach((row) => {
            strHTMLHall += '<div class="buying-scheme__row">';
            row.forEach((arg) => {
                switch (arg) {
                    case 'd':
                        strHTMLHall += '<span class="buying-scheme__chair buying-scheme__chair_disabled" data-chair="d"></span>';
                        break;
                    case 's':
                        strHTMLHall += '<span class="buying-scheme__chair buying-scheme__chair_standart" data-chair="s"></span>';
                        break;
                    case 'v':
                        strHTMLHall += '<span class="buying-scheme__chair buying-scheme__chair_vip" data-chair="v"></span>';
                        break;
                    case 't':
                        strHTMLHall += '<span class="buying-scheme__chair buying-scheme__chair_taken"></span>';
                        break;
                    case 'sl':
                        strHTMLHall += '<span class="buying-scheme__chair buying-scheme__chair_selected" data-chair=""></span>';
                        break;
                }
            });
            strHTMLHall += '</div>';
        });
        strHTMLHall += '</div>';

        return strHTMLHall;
    }

    installHandlerOnChairs() {
        this.chairs = document.querySelectorAll('.buying-scheme__row .buying-scheme__chair');
        Array.from(this.chairs).forEach((c,i) => c.addEventListener('click', () => {
            this.renameClassName(c,i);
            const index = this.findIndexConfHallArr(i);
            let stateChair = '';
            if (c.classList.contains('buying-scheme__chair_standart')) {
                stateChair = 's';
            } else if (c.classList.contains('buying-scheme__chair_vip')) {
                stateChair = 'v';
            } else if (c.classList.contains('buying-scheme__chair_selected')) {
                stateChair = 'sl';
            } else if (c.classList.contains('buying-scheme__chair_disabled')) {
                stateChair = 'd';
            } else if (c.classList.contains('buying-scheme__chair_taken')) {
                stateChair = 't';
            }
            this.confHallArr[index[0]][index[1]] = stateChair;
            const dataAttrConfHall = this.getArrToStr(this.confHallArr);
            this.confHall.dataset.confHall = dataAttrConfHall;
            if (this.selectedChairs.length > 0) {
                this.cost = 0;
                this.selectedChairsStr = '';
                this.selectedChairs.forEach((o,i,arr) => {
                    if (Object.keys(o)[0] === 's') {
                        this.cost += this.confPriceHallsArr.standart;
                        this.selectedChairsStr += Object.values(o)[0];
                        if (i !== arr.length - 1) {
                            this.selectedChairsStr += ',';
                        }
                    } else if (Object.keys(o)[0] === 'v') {
                        this.cost += this.confPriceHallsArr.vip;
                        this.selectedChairsStr += Object.values(o)[0];
                        if (i !== arr.length - 1) {
                            this.selectedChairsStr += ',';
                        }
                    }
                });
            } else {
                this.cost = 0;
                this.selectedChairsStr = '';
            }
            if (this.selectedChairsStr) {
                let magic = this.selectedChairsStr.split(',').sort((a, b) => a - b).join(', ');
                this.selectedChairsStr = magic;
            }
            document.querySelector('input[name="selected_chairs"]').value = this.selectedChairsStr;
            document.querySelector('input[name="cost"]').value = this.cost;
        }));
    }

    renameClassName(elem, i) {
        const index = this.findIndexConfHallArr(i);
        const numberChair = index[0] * this.quantityChairsInRow + index[1] + 1;
         if (elem.classList.contains('buying-scheme__chair_standart')) {
            elem.classList.remove('buying-scheme__chair_standart');
            elem.classList.add('buying-scheme__chair_selected');
            this.selectedChairs.push({s: numberChair});
        } else if (elem.classList.contains('buying-scheme__chair_vip')) {
            elem.classList.remove('buying-scheme__chair_vip');
            elem.classList.add('buying-scheme__chair_selected');
            this.selectedChairs.push({v: numberChair});
        } else if (elem.classList.contains('buying-scheme__chair_selected')) {
            elem.classList.remove('buying-scheme__chair_selected');
            const defaultClassChair = elem.dataset.chair;
            let defaultClassChairInstall = '';
            if (defaultClassChair === 's') {
                defaultClassChairInstall = 'buying-scheme__chair_standart';
            } else if (defaultClassChair === 'v') {
                defaultClassChairInstall = 'buying-scheme__chair_vip';
            }
            elem.classList.add(defaultClassChairInstall);
            const removeObj = this.selectedChairs.findIndex(o => Object.keys(o)[0] === defaultClassChair);
            if (~removeObj) this.selectedChairs.splice(removeObj, 1);
        }
    }

    findIndexConfHallArr(i) {
        return [Math.floor(i / this.quantityChairsInRow), i - Math.floor(i / this.quantityChairsInRow) * this.quantityChairsInRow]
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

    getObjStr(confPriceHall) {
        confPriceHall.split('|').forEach(a => {
            const arr = a.split(':');
            const typeChair = arr[0];
            switch (typeChair) {
                case 's':
                    this.confPriceHallsArr.standart = +arr[1];
                    break;
                case 'v':
                    this.confPriceHallsArr.vip = +arr[1];
                    break;
            }
        });
    }    
}

const confHallSeances = new ConfHallSeances();
confHallSeances.init();
