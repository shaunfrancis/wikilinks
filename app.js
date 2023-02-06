class Article{
    constructor(title){
        this.title = title;
    }

    async download(){
        let response = await fetch(`scripts/get_article.php?title=${encodeURI(this.title)}`);
        response = await response.json();
        if(response.status == 200){
            this.title = response.title;
            this.content = response.content;
        }
        else throw new Error(response.status);
    }

    parse(){
        let text = this.content;
        text = text.replace(/\\n/g, '');
        text = text.replace(/<a[^>]*href="((\/wiki\/(Wikipedia|File|Help|Template|Template_talk|Talk|User|User_talk|Special):)|(\/\/|http))[^<]*>/g, '<a class="invalid-link">');
        text = text.replace(/<a[^>]*href="\/wiki\//g, '<span class="link" data-target="');
        text = text.replace(/<a[^>]*>/g, '<span>');
        text = text.replace(/<\/a>/g, '</span>');

        const parser = new DOMParser();
        const html = parser.parseFromString(`<h1>${this.title}</h1>${text}`, 'text/html');

        let container = document.createElement('div'), child;
        container.classList.add('game-article');
        while(child = html.body.firstChild) container.appendChild(child);
        this.html = container;
    }

    makeInteractive(callback){
        [...this.html.querySelectorAll('[data-target]')].forEach( link => {
            const target = decodeURI(link.dataset.target).replace(/_/g, ' ');
            link.removeAttribute('data-target');
            link.addEventListener('click', () => {
                this.html.classList.add('loading');
                callback(new Article(target));
            });
        });
    }
}

class Game{
    constructor(initial, goal){
        this.initial = new Article(initial);
        this.goal = new Article(goal);
        this.clicks = -1;
    }

    async start(){
        this.startTime = Date.now();
        this.elapsed = 0;
        this.pausedTime = 0;

        setInterval(this.controller.bind(this), 500);

        this.next(this.initial);
    }

    controller(){
        if(this.paused) return;
        const elapsed = ((Date.now() - this.startTime - this.pausedTime) / 1000).toFixed(0);
        if(elapsed != this.elapsed){
            this.elapsed = elapsed;
            document.getElementById('timer').innerHTML = this.elapsed;
        }
    }

    async next(article){
        this.clicks += 1;

        this.pauseTimer();
        await article.download();
        article.parse();
        article.makeInteractive(this.next.bind(this));
        document.getElementById('game-content').innerHTML = "";
        document.getElementById('game-content').appendChild(article.html);
        this.resumeTimer();
    }

    pauseTimer(){ this.paused = true; this.pausedAt = Date.now() }
    resumeTimer(){ this.pausedTime += Date.now() - this.pausedAt; this.paused = false }
}

async function temp_game(){

    document.body.classList.remove('main-visible');
    document.body.classList.add('game-visible');
    
    const game = new Game("United Kingdom", "Tony Blair");
    game.start();

}