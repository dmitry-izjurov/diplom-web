class ConfSeances {
    constructor() {
        this.confSeances = document.querySelectorAll('.conf-step__seances-hall');        // все залы
        this.seances = document.querySelectorAll('.conf-step__seances-movie');           // все сеансы
    }

    init() {
        Array.from(this.confSeances).forEach(hs => {
            if (!hs.querySelector('.conf-step__seances-movie')) {
                hs.remove();
            }
        });

        Array.from(this.seances).forEach(s => this.getAttrForSeances(s));
    }

    getAttrForSeances(seance) {
        const duration = +seance.dataset.filmDuration / 2;
        const time = seance.dataset.seanceTimeBegin.split(':');
        const hour = +time[0] / 24 * 720;
        const minute = +time[1] / 60 / 24 * 720;
        const timeBegin = hour + minute;
        seance.setAttribute('style', `width: ${duration}px; background-color: rgb(${this.getRandomIntInclusive(0, 255)}, 255, ${this.getRandomIntInclusive(0, 255)}); left: ${timeBegin}px;`)
    }

    getRandomIntInclusive(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

}

const confSeances = new ConfSeances();
confSeances.init();
