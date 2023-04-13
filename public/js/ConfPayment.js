class ConfPayment {
    constructor() {
        this.film = document.querySelector('.ticket__info-wrapper').dataset.film              // название фильма
        this.hall = document.querySelector('.ticket__info-wrapper').dataset.hall              // название зала
        this.chairs = document.querySelector('.ticket__info-wrapper').dataset.chairs          // забронированные места
        this.start = document.querySelector('.ticket__info-wrapper').dataset.start            // начало сеанса
        this.buttonGetQRCode = document.querySelector('.acceptin-button');                    // кнопка получить код бронирования
    }

    init() {
        this.buttonGetQRCode.addEventListener('click', () => {
            document.querySelector('.ticket__check-title').textContent = 'Электронный билет';
            document.getElementById('ticket-info').remove();
            document.getElementById('ticket-hint').textContent = 'Покажите QR-код нашему контроллеру для подтверждения бронирования.';
            this.buttonGetQRCode.remove();
            new QRCode(document.getElementById("qrcode"), {
                text: `Фильм: ${this.film}\nМеста: ${this.chairs}\nЗал: ${this.hall}\nНачало сеанса: ${this.start}\n`,
                width: 196,
                height: 196,
                colorDark : "#000000",
                colorLight : "#ffffff",
            });
        });
    }
}

const confPayment = new ConfPayment();
confPayment.init();
