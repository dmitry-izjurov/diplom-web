class ConfMain {
    constructor() {
        this.movie = document.querySelectorAll('.movie');                                        // Все фильмы
        this.elemsMovieSeancesHall = document.querySelectorAll('.movie-seances__hall');          // Все залы с сеансами
        this.images = ['poster1.jpg', 'poster2.jpg']                                             // картинки для постеров из галареи
        this.countries = ['Россия', 'Индия', 'Китай', 'США', 'Канада', 'Франция'];
        this.description = [
            'Две сотни лет назад малороссийские хутора разоряла шайка нехристей-ляхов во главе с могущественным колдуном.',
            '20 тысяч лет назад Земля была холодным и неуютным местом, в котором смерть подстерегала человека на каждом шагу.',
            'Самые опасные хищники Вселенной, прибыв из глубин космоса, высаживаются на улицах маленького городка, чтобы начать свою кровавую охоту. Генетически модернизировав себя с помощью ДНК других видов, охотники стали ещё сильнее, умнее и беспощаднее.'
        ];
    }

    init() {
        Array.from(this.elemsMovieSeancesHall).forEach(h => h.querySelector('.movie-seances__time-block') ?? h.remove());
        Array.from(this.movie).forEach(f => f.querySelector('.movie-seances__hall') ?? f.remove());
        
        const elemListSeances = document.querySelectorAll('.movie-seances__list');
        elemListSeances.forEach(ul => {
            const arrObjForSort = [];
            Array.from(ul.querySelectorAll('.movie-seances__time-block')).forEach(li => {
                arrObjForSort.push({[li.dataset.time]: li.outerHTML}); 
            });

            const arrObjForSortStr = JSON.stringify(arrObjForSort);
            const arrObjSortIndex = arrObjForSort.map(obj => JSON.stringify(obj));
            arrObjSortIndex.sort();
            const arrObjSortIndexUnParse = arrObjSortIndex.map(a => JSON.parse(a));
            const arrObjSortStr = JSON.stringify(arrObjSortIndexUnParse);
            if (arrObjForSortStr !== arrObjSortStr) {
                let ulForRender = '<ul class="movie-seances__list">';
                arrObjSortIndexUnParse.forEach(a => ulForRender += Object.values(a)[0]);
                ulForRender += '</ul>';
                ul.insertAdjacentHTML('afterend', ulForRender);
                ul.remove();
            }
        });

        const elemsImages = document.querySelectorAll('.movie__poster-image');
        Array.from(elemsImages).forEach(img => img.setAttribute('src', `i/${this.images[this.getValue(this.images)]}`));
        const elemsMovieSynopsis = document.querySelectorAll('.movie__synopsis');
        Array.from(elemsMovieSynopsis).forEach(p => p.textContent = this.description[this.getValue(this.description)]);
        const elemsMovieDataOrigin = document.querySelectorAll('.movie__data-origin');
        Array.from(elemsMovieDataOrigin).forEach(s => s.textContent = this.countries[this.getValue(this.countries)]);
    }

    getValue(arr) {
        return Math.floor(Math.random() * arr.length);
    }
}

const confMain = new ConfMain();
confMain.init();
