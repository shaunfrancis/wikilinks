<?php include '../scripts/ini.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="app.js"></script>
    <link rel="stylesheet" type="text/css" href="styles/app.css" />
    <link rel="stylesheet" type="text/css" href="styles/wikipedia.css" />
    <title>Wikilinks - The Wikipedia Racing Game! - Tennessine</title>
</head>
<body class="main-visible">
    <?php $external_header = TRUE; include '../components/header.php'; ?>

    <main class="page">
        <aside>
            <img id="logo" alt="Wikilinks" src="images/logo.svg" />
            <div id="mode-container">
                <div class="card">
                    <h2>Single Player</h2>
                </div>
                <div class="card">
                    <h2>Multiplayer</h2>
                </div>
                <div class="card">
                    <h2>Tutorial</h2>
                </div>
            </div>
        </aside>
        <div class="content">
            <section>
                <h1>Today's Game</h1>
                <div class="featured-game-container">
                    
                    <div class="featured-article">
                        <div class="jigsaw-pattern" style="background-image:url(https://upload.wikimedia.org/wikipedia/en/a/a5/Super_Mario_Bros._3_coverart.png)"></div>
                        <div class="featured-article-content">
                            <h1>Super Mario Bros. 3</h1>
                            <p>Super Mario Bros. 3 is a platform game developed and published by Nintendo for the Nintendo Entertainment System (NES). It was released for home consoles in Japan on October 23, 1988, in North America on February 12, 1990 and in Europe on August 29, 1991. It was developed by Nintendo Entertainment Analysis and Development, led by Shigeru Miyamoto and Takashi Tezuka.</p>
                        </div>
                    </div>

                    <img src="images/arrow.svg" alt="to" class="featured-arrow" />

                    <div class="featured-article">
                        <div class="jigsaw-pattern" style="background-image:url(https://upload.wikimedia.org/wikipedia/commons/b/b7/William_Etty_%281787–1849%29_–_Candaules%2C_King_of_Lydia%2C_Shews_his_Wife_by_Stealth_to_Gyges%2C_One_of_his_Ministers%2C_as_She_Goes_to_Bed_–_N00358_–_Tate.jpg)"></div>
                        <div class="featured-article-content">
                            <h1>Candaules, King of Lydia, Shews his Wife by Stealth to Gyges, One of his Ministers, as She Goes to Bed</h1>
                            <p>Candaules, King of Lydia, Shews his Wife by Stealth to Gyges, One of his Ministers, as She Goes to Bed, occasionally formerly known as The Imprudence of Candaules, is a 45.1 by 55.9 cm (17.8 by 22.0 in) oil painting on canvas by English artist William Etty, first exhibited at the Royal Academy in 1830.</p>
                        </div>
                    </div>
                    
                </div>

                <h1>This Week's Games</h1>
                <div class="featured-game-container">
                    
                    <div class="featured-article">
                        <div class="jigsaw-pattern" style="background-image:url(https://upload.wikimedia.org/wikipedia/en/b/b3/K%27_KOFXI.png)"></div>
                        <div class="featured-article-content">
                            <h1>K'</h1>
                            <p>K Dash (Japanese: ケイ・ダッシュ, Hepburn: Kei Dasshu, commonly stylized as K′ and also known as K Prime in certain English language materials), is a character from The King of Fighters fighting game series developed by SNK. He debuted as the leader of the Hero Team in The King of Fighters '99, released in 1999. </p>
                        </div>
                    </div>

                    <img src="images/arrow.svg" alt="to" class="featured-arrow" />

                    <div class="featured-article">
                        <div class="jigsaw-pattern" style="background-image:url(https://upload.wikimedia.org/wikipedia/en/0/0e/Dalek_Invasion_of_Earth.jpg)"></div>
                        <div class="featured-article-content">
                            <h1>The Dalek Invasion of Earth</h1>
                            <p>The Dalek Invasion of Earth is the second serial of the second season in the British science fiction television series Doctor Who. Written by Terry Nation and directed by Richard Martin, the serial was broadcast on BBC1 in six weekly parts from 21 November to 26 December 1964.</p>
                        </div>
                    </div>
                    
                </div>

                <div class="featured-game-container">
                    
                    <div class="featured-article">
                        <div class="jigsaw-pattern" style="background-image:url(https://upload.wikimedia.org/wikipedia/commons/1/18/Lola2.jpeg)"></div>
                        <div class="featured-article-content">
                            <h1>Albania in the Eurovision Song Contest 2013</h1>
                        </div>
                    </div>

                    <img src="images/arrow.svg" alt="to" class="featured-arrow" />

                    <div class="featured-article">
                        <div class="jigsaw-pattern" style="background-image:url(https://upload.wikimedia.org/wikipedia/commons/d/d3/Arena_%28web_browser%29_screenshot.png)"></div>
                        <div class="featured-article-content">
                            <h1>Arena (web browser)</h1>
                        </div>
                    </div>
                    
                </div>

                <button onclick="temp_game()">temp_game</button>

            </section>
        </div>
    </main>

    <section id="game" class="page">
        <section id="game-banner">
            <div id="initial-jigsaw-path-piece" class="jigsaw-path-piece"></div>
            <div id="jigsaw-path-container"></div>
            <div id="goal-jigsaw-path-piece" class="jigsaw-path-piece"></div>
        </section>
        <aside>
            <div class="current-stat">
                <div id="current-points" class="current-stat-value">0</div>
                <div class="current-stat-label">points</div>
            </div>
            <div class="current-stat">
                <div id="current-clicks" class="current-stat-value">0</div>
                <div class="current-stat-label">clicks</div>
            </div>
            <div class="current-stat">
                <div id="current-seconds" class="current-stat-value">0</div>
                <div class="current-stat-label">seconds</div>
            </div>
        </aside>
        <section id="game-content" class="content">
            
        </section>
    </section>

    <?php echo file_get_contents('images/jigsaw-clips.svg'); ?>
</body>
</html>