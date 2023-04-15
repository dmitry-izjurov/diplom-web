class ConfIsSellTicket {
    constructor() {
        this.confSellTicketHalls = document.querySelectorAll('.conf-hall_sell');                 // все залы
        this.initElemConfHalls = this.confSellTicketHalls.item(0);                               // первый зал из базы данных и последующий при клике
    }

    init() {
        const confSellTicketHall = this.initElemConfHalls.dataset.confHallSell;
        this.renderButton(confSellTicketHall);

        Array.from(this.confSellTicketHalls).forEach(h => h.addEventListener('click', () => {
            if (this.initElemConfHalls !== h) {
                this.initElemConfHalls = h;
                this.renderButton(h.dataset.confHallSell);
            }
        }));
    }

    renderButton(param) {
        const formIsSellTicket = document.querySelector('form[name="form-is_sell_ticket"]');
        const inputSellTicket = formIsSellTicket.querySelector('input[name="is_sell_ticket"]');
        let buttonTrue = `<button id="buttonSellTrue" class="conf-step__button conf-step__button-accent">Открыть продажу билетов</button>`;
        let buttonFalse = `<button id="buttonSellFalse" class="conf-step__button conf-step__button-accent conf-step__button_stop">Приостановить продажу билетов</button>`;

        if (formIsSellTicket.querySelector('button')) {
            formIsSellTicket.querySelector('button').remove();
        }
        if (!!+param) {
            formIsSellTicket.insertAdjacentHTML('beforeend', buttonFalse);
            buttonFalse = document.getElementById('buttonSellFalse');
            this.submit(buttonFalse, inputSellTicket, !!+param);
        } else {
            formIsSellTicket.insertAdjacentHTML('beforeend', buttonTrue);
            buttonTrue = document.getElementById('buttonSellTrue');
            this.submit(buttonTrue, inputSellTicket, !!+param);
        }
    }

    submit(button, input, param) {
        button.addEventListener('click', () => {
            if (param) {
                input.value = `${this.initElemConfHalls.dataset.id}=0`;
            } else {
                input.value = `${this.initElemConfHalls.dataset.id}=1`;
            }
        });
    }
}

const confIsSellTicket = new ConfIsSellTicket();
confIsSellTicket.init();
