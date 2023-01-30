class Article{
    constructor(title){
        this.title = title;
    }

    async load(){
        let request = await fetch('temp_article.php');
        request = await request.json();
        this.content = request;
    }

    parse(){
        let text = this.content.parse.text['*'];
        text = text.replace(/\\n/g, '');
        text = text.replace(/<a[^>]*href="((\/wiki\/(Wikipedia|File|Help|Template|Template_talk|Talk|User|User_talk|Special):)|(\/\/|http))[^<]*>/g, '<a class="invalid-link">');
        text = text.replace(/<a[^>]*href="\/wiki\//g, '<span class="link" data-target="');
        text = text.replace(/<a[^>]*>/g, '<span>');
        text = text.replace(/<\/a>/g, '</span>');
        this.html = `<h1>${this.content.parse.title}</h1>${text}`;
    }
}

async function temp_game(){
    const article = new Article("United Kingdom");
    await article.load();
    article.parse();
    document.getElementById('game-content').innerHTML = article.html;
}

window.addEventListener('DOMContentLoaded', temp_game);