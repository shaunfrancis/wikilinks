class Article{
    constructor(title){
        this.title = title;
    }

    async exists(){
        let response = await fetch(`scripts/article_exists.php?title=${encodeURI(this.title)}`);
        response = await response.json();
        if(response.status == 200) return response.exists;
        else throw new Error(response.status);
    }

    async download(){
        let response = await fetch(`scripts/get_article.php?title=${encodeURI(this.title)}`);
        response = await response.json();
        if(response.status == 200){
            this.title = response.title;
            this.content = response.content;
        }
        else this.content = "fail";
    }

    parse(){
        let text = this.content;
        text = text.replace(/\\n/g, '');
        text = text.replace(/<a[^>]*href="((\/wiki\/(Wikipedia|File|Help|Template|Template_talk|Talk|User|User_talk|Special):)|(\/\/|http))[^<]*>/g, '<a class="invalid-link">');
        text = text.replace(/<a[^>]*href="\/wiki\//g, '<span class="link" data-target="');
        text = text.replace(/<a[^>]*>/g, '<span>');
        text = text.replace(/<\/a>/g, '</span>');
        this.html = `<h1>${this.title}</h1>${text}`;
    }
}

class Game{
    constructor(initial, target){
        this.initial = new Article(initial);
        this.target = new Article(target);
    }

    async start(){
        await this.initial.download();
        this.initial.parse();
        document.getElementById('game-content').innerHTML = this.initial.html;
    }
}

async function temp_game(){

    document.body.classList.remove('main-visible');
    document.body.classList.add('game-visible');
    
    const game = new Game("United Kingdom", "Tony Blair");
    game.start();

}