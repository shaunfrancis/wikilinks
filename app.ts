class Article{
    title: string;
    content: string;
    downloaded: boolean;
    tableOfContents: TableOfContents;
    html: HTMLElement;

    constructor(title : string){
        this.title = title;
    }

    public async download() : Promise<void | never>{
        const response = await fetch(`scripts/get_article.php?title=${encodeURI(this.title)}`);
        this.downloaded = true;
        if(response.status == 200){
            const json = await response.json();
            this.title = json.title;
            this.content = json.content;
        }
        else throw new Error( response.status.toString() );
    }

    public parse() : void{
        let text = this.content;
        text = text.replace(/\\n/g, '');
        text = text.replace(/<a[^>]*href="((\/wiki\/(Wikipedia|File|Help|Template|Template_talk|Talk|User|User_talk|Special):)|(\/\/|http))[^<]*>/g, '<a class="invalid-link">');
        text = text.replace(/<a[^>]*href="\/wiki\//g, '<span class="link" data-target="');
        text = text.replace(/<a[^>]*>/g, '<span>');
        text = text.replace(/<\/a>/g, '</span>');

        const parser = new DOMParser();
        const html = parser.parseFromString(`<h1 id="article-title">${this.title}</h1>${text}`, 'text/html');

        let container = document.createElement('div'), child;
        container.classList.add('game-article');
        while(child = html.body.firstChild) container.appendChild(child);
        this.html = container;

        this.tableOfContents = new TableOfContents(container);
    }

    public makeInteractive(callback : (article : Article) => any ) : void{
        [...this.html.querySelectorAll('[data-target]')].forEach( link => {
            if(link instanceof HTMLElement){
                const target = decodeURI(link.dataset.target).replace(/_/g, ' ');
                link.removeAttribute('data-target');
                link.addEventListener('click', () => {
                    this.tableOfContents.listenForScroll = false;
                    this.html.classList.add('loading');
                    this.tableOfContents.html.classList.add('loading');
                    callback(new Article(target));
                });
            }
        });

        this.tableOfContents.listenForScroll = true;
    }
}

type ArticleSection = {
    label: string,
    element: HTMLElement,
    li?: HTMLElement,
    children: ArticleSection[]
}
class TableOfContents{
    articleHtml: HTMLElement;
    html: HTMLElement;
    structure: ArticleSection[];

    constructor(articleHtml : HTMLElement){
        this.articleHtml = articleHtml;
        this.parse();
        this.build();
    }

    private parse() : void{
        this.structure = [ {label: "(Top)", element: document.body, children: []} ];
        let currentTree = [], previousLevel = 2;
        
        this.articleHtml.querySelectorAll("h2, h3, h4, h5, h6").forEach( heading => {
            if(!(heading instanceof HTMLElement)) return;

            const level = parseInt(heading.tagName[1]), headline = heading.querySelector(".mw-headline");
            if(!headline) return;
            
            const entry = {
                label: headline.innerHTML,
                element: heading,
                children: []
            };

            if(level <= previousLevel){
                level == 2 ? this.structure.push(entry) : currentTree[level - 3].children.push(entry);
                previousLevel = level;
                currentTree.length = level - 1;
                currentTree[currentTree.length - 1] = entry;
            }
            else{
                currentTree[currentTree.length - 1].children.push(entry);
                currentTree.push(entry);
                previousLevel += 1;
            }

        });
    }

    private build() : void{
        this.html = document.createElement('ul');
        this.structure.forEach( entry => {
            this.buildBranch(entry, this.html, true);
        });
    }

    private buildBranch(entry : ArticleSection, parentUl : HTMLElement, topLevel? : boolean) : void{
        const li = document.createElement('li');
        entry.li = li;

        if(topLevel && entry.children.length > 0){
            li.classList.add('closed');
            const expand = document.createElement('div');
            expand.classList.add('contents-expand');
            expand.addEventListener('click', () => {
                li.classList.toggle('closed');
            });
            li.appendChild(expand);
        }

        const label = document.createElement('div');
        label.classList.add('contents-label');
        label.innerHTML = entry.label;
        li.appendChild(label);
        parentUl.appendChild(li);
        
        label.addEventListener('click', () => {
            entry.element.scrollIntoView();
        });

        if(entry.children.length > 0){
            const ul = document.createElement('ul');
            entry.children.forEach( childEntry => {
                this.buildBranch(childEntry, ul);
            });
            li.appendChild(ul);
        }
    }

    private _highlightCurrentEntry: () => any;
    public set listenForScroll(bool : boolean){
        if(bool) document.addEventListener('scroll', this._highlightCurrentEntry = this.highlightCurrentEntry.bind(this));
        else document.removeEventListener('scroll', this._highlightCurrentEntry);
    }

    private highlightCurrentEntry() : void{
        let leastNegative = -Infinity;
        let currentEntry : ArticleSection, currentTopLevel : ArticleSection;
        
        const checkPositionOf = (entries : ArticleSection[], topLevel? : boolean) => {
            for(let i = entries.length - 1; i >= 0; i--){
                let entry = entries[i];

                const position = entry.element.getBoundingClientRect();
                if(position.y - 40 <= 0 && position.y - 40 > leastNegative){
                    leastNegative = position.y;
                    currentEntry = entry;
                    if(topLevel) currentTopLevel = entry;
                    checkPositionOf(entry.children);
                }

            };
        }
        checkPositionOf(this.structure, true);

        const unselectEntries = (entries : ArticleSection[]) => {
            entries.forEach( entry => {
                entry.li.classList.remove('current-entry', 'current-entry-toplevel');
                unselectEntries(entry.children);
            });
        }
        unselectEntries(this.structure);

        if(currentEntry){
            currentEntry.li.classList.add('current-entry');
            if(currentEntry != currentTopLevel) currentTopLevel.li.classList.add('current-entry-toplevel');
        }
    }

}

type PathStep = { article: Article, time: number, pathPiece?: PathPiece }
type PathPiece = { element: HTMLElement, visible: boolean }
class Game{
    initial: Article;
    goal: Article;
    clicks: number;
    path: PathStep[];

    startTime: number;
    elapsed: number;
    pausedTime: number;
    pausedAt: number;
    paused: boolean;

    constructor(initial : string, goal : string){
        this.initial = new Article(initial);
        this.goal = new Article(goal);
        this.clicks = -1;

        this.path = [];
    }

    public async start() : Promise<void>{
        document.documentElement.scrollTo({ top: 0, behavior: 'smooth' });
        document.getElementById('initial-jigsaw-path-piece').innerHTML = this.initial.title;
        document.getElementById('goal-jigsaw-path-piece').innerHTML = this.goal.title;

        this.startTime = Date.now();
        this.elapsed = 0;
        this.pausedTime = 0;

        await Promise.all([this.initial.download(), this.goal.download()]);
        //update titles in case of redirect
        document.getElementById('initial-jigsaw-path-piece').innerHTML = this.initial.title;
        document.getElementById('goal-jigsaw-path-piece').innerHTML = this.goal.title;

        setInterval(this.controller.bind(this), 500);

        this.next(this.initial);
    }

    private controller() : void{
        if(this.paused) return;
        const elapsed = Math.round((Date.now() - this.startTime - this.pausedTime) / 1000);
        if(elapsed != this.elapsed){
            this.elapsed = elapsed;
            this.updateStats();
        }
    }

    private async next(article : Article) : Promise<void>{
        document.documentElement.scrollTo({ top: 0, behavior: 'smooth' });
        this.clicks += 1;
        this.updateStats();

        this.pauseTimer();
        if(!article.downloaded) await article.download();

        if(article.title == this.goal.title) return this.win();

        article.parse();
        article.makeInteractive(this.next.bind(this));

        const pathStep : PathStep = {
            article: article,
            time: this.elapsed
        };
        this.path.push(pathStep);

        document.getElementById('game-content').innerHTML = "";
        document.getElementById('game-content').appendChild(article.html);
        document.getElementById('table-of-contents').innerHTML = "";
        document.getElementById('table-of-contents').appendChild(article.tableOfContents.html);

        this.resumeTimer();

        if(this.clicks > 0) pathStep.pathPiece = this.updateJigsawPath(article.title);

    }

    private pauseTimer() : void{ this.paused = true; this.pausedAt = Date.now() }
    private resumeTimer() : void{ this.pausedTime += Date.now() - this.pausedAt; this.paused = false }

    private updateStats() : void{
        document.getElementById('current-seconds').innerHTML = this.elapsed.toString();
        document.getElementById('current-clicks').innerHTML = this.clicks.toString();
        document.getElementById('current-points').innerHTML = (10*this.clicks + Math.floor(this.elapsed/10)).toString();
    }

    private updateJigsawPath(title : string) : PathPiece{
        const pathPiece = document.createElement('div');
        pathPiece.classList.add('jigsaw-path-piece');
        pathPiece.innerHTML = title;
        document.getElementById('jigsaw-path-container').appendChild(pathPiece);

        while(document.getElementById('game-banner').getBoundingClientRect().width > window.innerWidth){
            const step = this.path.find( step => "pathPiece" in step && step.pathPiece.visible);

            if(step){
                if(step.pathPiece.element.parentElement) step.pathPiece.element.parentElement.removeChild(step.pathPiece.element);
                step.pathPiece.visible = false;
                document.getElementById('jigsaw-path-container').classList.add('pieces-hidden');
            }
            else{ //if all other pieces are hidden, truncate the most recent piece
                if(pathPiece.innerHTML.length < 8) break;
                pathPiece.innerHTML = pathPiece.innerHTML.substring(0, pathPiece.innerHTML.length - 8) + "&hellip;";
            }
        }

        return { element: pathPiece, visible: true };
    }

    private win() : void{
        document.body.classList.remove('game-visible');
        document.body.classList.add('win-visible');
    }
}

async function temp_game(){

    document.body.classList.remove('main-visible');
    document.body.classList.add('game-visible');

    const temp_start = <HTMLInputElement>document.getElementById('temp_start');
    const temp_end = <HTMLInputElement>document.getElementById('temp_end');
    const game = new Game(temp_start.value, temp_end.value);
    game.start();

}