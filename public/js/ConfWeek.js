class ConfWeek {
    constructor() {
        this.pageNavWeek = document.querySelector('.page-nav');                       // элемент с навигацией по дням недели
        this.currentDayWeek = 0;                                                      // День недели сегодня
        this.nextDayWeek;                                                             // Последующие дни недели
        this.letterDayWeek;                                                           // Буквенное выражение дня недели
        this.currentDate = 1;                                                         // Число сегодня
        this.nextDate;                                                                // Последующие числа
        this.dateProg;                                                                // Вычисляемое значение даты
    }

    init() {
        this.getDate();
        const elemsNav = this.pageNavWeek.querySelectorAll('.page-nav__day');
        Array.from(elemsNav).forEach((a,i, arr) => {
            if (i !== arr.length - 1) {
                a.addEventListener('click', () => {
                    if (!a.classList.contains('page-nav__day_chosen')) {
                        Array.from(elemsNav).find(elem => elem.classList.contains('page-nav__day_chosen')).classList.remove('page-nav__day_chosen');
                        a.classList.add('page-nav__day_chosen');
                    }
                });
            }
        });
    }

    getDate() {
        const days = ['Вск', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']
        const date = new Date();
        this.currentDayWeek = date.getDay();
        this.currentDate = date.getDate();
        this.letterDayWeek = days[this.currentDayWeek];
        this.nextDayWeek = this.currentDayWeek;
        this.nextDate = this.currentDate;

        for (let i = 0; i < 6; i++) {
            this.dateProg = new Date();
            this.dateProg.setDate(date.getDate() + i);
            this.nextDate = this.dateProg.getDate();
            this.nextDayWeek = this.dateProg.getDay();
            this.letterDayWeek = days[this.dateProg.getDay()]
            this.pageNavWeek.insertAdjacentHTML('beforeend', this.renderDays(this.letterDayWeek, this.nextDate));
        }

        this.pageNavWeek.insertAdjacentHTML('beforeend', '<a class="page-nav__day page-nav__day_next" href="#"></a>');
    }

    renderDays(day, date) {
        if (this.currentDayWeek === this.nextDayWeek && this.currentDate === this.nextDate && this.nextDayWeek !== 6 && this.nextDayWeek !== 0) {
            return `
                <a class="page-nav__day page-nav__day_today page-nav__day_chosen" href="#">
                    <span class="page-nav__day-week">${day}</span><span class="page-nav__day-number">${date}</span>
                </a>
            `;
        } else if (this.currentDayWeek === this.nextDayWeek && this.currentDate === this.nextDate && (this.nextDayWeek === 6 || this.nextDayWeek === 0)) {
            return `
                <a class="page-nav__day page-nav__day_today page-nav__day_weekend page-nav__day_chosen" href="#">
                    <span class="page-nav__day-week">${day}</span><span class="page-nav__day-number">${date}</span>
                </a>
            `;
        } else if (this.currentDayWeek !== this.nextDayWeek && this.currentDate !== this.nextDate && (this.nextDayWeek === 6 || this.nextDayWeek === 0)) {
            return `
                <a class="page-nav__day page-nav__day_weekend" href="#">
                    <span class="page-nav__day-week">${day}</span><span class="page-nav__day-number">${date}</span>
                </a>
            `;
        } else {
            return `
                <a class="page-nav__day" href="#">
                    <span class="page-nav__day-week">${day}</span><span class="page-nav__day-number">${date}</span>
                </a>
            `;
        }
         
    }
}

const confWeek = new ConfWeek();
confWeek.init();
