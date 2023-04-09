class ConfPriceHalls {
    constructor() {
        this.confPriceHalls = document.querySelectorAll('.conf-hall_price');                 // все залы
        this.initElemConfHalls = this.confPriceHalls.item(0);                                // первый зал из базы данных и последующий при клике
        this.elemInputStChair = document.getElementById('input-st-chair');                   // инпут для ввода цены за обычное кресло
        this.elemInputVipChair = document.getElementById('input-vip-chair');                 // инпут для ввода цены за vip кресло
        this.confPriceHallsArr = {};                                                         // все цены на кресла
    }

    init() {
        const confPriceHall = this.initElemConfHalls.dataset.priceChair;
        this.getObjStr(confPriceHall);
        this.installHandlerOnChangePrice(this.elemInputStChair);
        this.installHandlerOnChangePrice(this.elemInputVipChair);

        Array.from(this.confPriceHalls).forEach(h => h.addEventListener('click', () => {
            if (this.initElemConfHalls !== h) {
                this.initElemConfHalls = h;
                this.getObjStr(h.dataset.priceChair);
                this.getDefaultStatePrice(this.initElemConfHalls);
            }
        }));

        this.getDefaultStatePrice(this.initElemConfHalls);

        // Форма для отправки обновлённой конфигурации цен кресел
        const formPriceOfChair = document.querySelector('form[name="form-price_of_chair"]');
        formPriceOfChair.addEventListener('submit', () => {
            const inputPriceOfChair = formPriceOfChair.querySelector('input[name="price_of_chair"]');
            let strDataPriceOfChair = '';
            this.confPriceHalls.forEach((h,i,arr) => {
                strDataPriceOfChair += h.dataset.id + '=' + h.dataset.priceChair;
                if (i !== arr.length - 1) {
                    strDataPriceOfChair += '-';
                }
            });
            inputPriceOfChair.value = strDataPriceOfChair;
        });
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
        
        this.elemInputStChair.value = this.confPriceHallsArr.standart;
        this.elemInputVipChair.value = this.confPriceHallsArr.vip;
    }

    installHandlerOnChangePrice(elem) {
        elem.addEventListener('change', () => {
            if (Number.isNaN(+elem.value)) {
                elem.value = 100;
            } else if (+elem.value < 1) {
                elem.value = 1;
            } else if (+elem.value > 10000) {
                elem.value = 10000;
            }

            if (elem.getAttribute("id") === 'input-st-chair') {
                this.confPriceHallsArr.standart = +elem.value;
            } else if (elem.getAttribute("id") === 'input-vip-chair') {
                this.confPriceHallsArr.vip = +elem.value;
            }
            this.initElemConfHalls.dataset.priceChair = this.getStrObj(this.confPriceHallsArr);
        });
    }

    getStrObj(obj) {
        let str = '';
        if (obj.hasOwnProperty('standart')) {
            str += 's:' + obj.standart + '|'
        }
        if (obj.hasOwnProperty('vip')) {
            str += 'v:' + obj.vip
        }
        return str;
    }

    getDefaultStatePrice(hall) {
        const htmlButtonCancelPriceHall = `
            <button id="cancel-button-hall-price" type="button" class="conf-step__button conf-step__button-regular">Отмена</button>
        `;
        document.getElementById('cancel-button-hall-price').remove();
        document.getElementById('save-button-conf-hall-price').insertAdjacentHTML('beforebegin', htmlButtonCancelPriceHall);
        const buttonCancelHallPrice = document.getElementById('cancel-button-hall-price');
        buttonCancelHallPrice.addEventListener('click', () => {
            hall.dataset.priceChair = hall.dataset.defaultPriceChair;
            this.getObjStr(hall.dataset.priceChair);
        });
    }

}

const confPriceHalls = new ConfPriceHalls();
confPriceHalls.init();
