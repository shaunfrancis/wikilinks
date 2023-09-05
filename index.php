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
            <p id="explainer">Race between two Wikipedia articles using only the links in each article, as quickly and in as few clicks as possible!</p>
            <div id="mode-container" style="display:none">
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
                <?php include 'scripts/todays_game.php'; ?>
                <div class="featured-game-container">
                    
                    <div class="featured-article">
                        <div class="jigsaw-pattern" style="background-image:url(<?php echo $todays_game["initial_image"]; ?>)"></div>
                        <div class="featured-article-content">
                            <h2><?php echo $todays_game["initial"]; ?></h2>
                        </div>
                    </div>

                    <img src="images/arrow.svg" alt="to" class="featured-arrow" />

                    <div class="featured-article">
                        <div class="jigsaw-pattern" style="background-image:url(<?php echo $todays_game["target_image"]; ?>)"></div>
                        <div class="featured-article-content">
                            <h2><?php echo $todays_game["goal"]; ?></h2>
                        </div>
                    </div>
                </div>

                <h1>This Week's Games</h1>
                <div class="featured-games-container">
                    <div class="featured-game-container">
                        
                        <div class="featured-article">
                            <div class="jigsaw-pattern" style="background-image:url(https://upload.wikimedia.org/wikipedia/en/b/b3/K%27_KOFXI.png)"></div>
                            <div class="featured-article-content">
                                <h2>K'</h2>
                                <p>K Dash (Japanese: ケイ・ダッシュ, Hepburn: Kei Dasshu, commonly stylized as K′ and also known as K Prime in certain English language materials), is a character from The King of Fighters fighting game series developed by SNK. He debuted as the leader of the Hero Team in The King of Fighters '99, released in 1999. </p>
                            </div>
                        </div>

                        <img src="images/arrow.svg" alt="to" class="featured-arrow" />

                        <div class="featured-article">
                            <div class="jigsaw-pattern" style="background-image:url(https://upload.wikimedia.org/wikipedia/en/0/0e/Dalek_Invasion_of_Earth.jpg)"></div>
                            <div class="featured-article-content">
                                <h2>The Dalek Invasion of Earth</h2>
                                <p>The Dalek Invasion of Earth is the second serial of the second season in the British science fiction television series Doctor Who. Written by Terry Nation and directed by Richard Martin, the serial was broadcast on BBC1 in six weekly parts from 21 November to 26 December 1964.</p>
                            </div>
                        </div>
                        
                    </div>

                    <div class="featured-game-container">
                        
                        <div class="featured-article">
                            <div class="jigsaw-pattern" style="background-image:url(https://upload.wikimedia.org/wikipedia/commons/1/18/Lola2.jpeg)"></div>
                            <div class="featured-article-content">
                                <h2>Albania in the Eurovision Song Contest 2013</h2>
                            </div>
                        </div>

                        <img src="images/arrow.svg" alt="to" class="featured-arrow" />

                        <div class="featured-article">
                            <div class="jigsaw-pattern" style="background-image:url(https://upload.wikimedia.org/wikipedia/commons/d/d3/Arena_%28web_browser%29_screenshot.png)"></div>
                            <div class="featured-article-content">
                                <h2>Arena (web browser)</h2>
                            </div>
                        </div>
                        
                    </div>

                    <div class="featured-game-container">
                        
                        <div class="featured-article">
                            <div class="jigsaw-pattern" style="background-image:url(https://upload.wikimedia.org/wikipedia/commons/1/18/Lola2.jpeg)"></div>
                            <div class="featured-article-content">
                                <h2>Albania in the Eurovision Song Contest 2013</h2>
                            </div>
                        </div>

                        <img src="images/arrow.svg" alt="to" class="featured-arrow" />

                        <div class="featured-article">
                            <div class="jigsaw-pattern" style="background-image:url(https://upload.wikimedia.org/wikipedia/commons/d/d3/Arena_%28web_browser%29_screenshot.png)"></div>
                            <div class="featured-article-content">
                                <h2>Arena (web browser)</h2>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <input id="temp_start" value="United Kingdom" />
                <input id="temp_end" value="Island country" />
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
            <div id="current-stats">
                <div class="current-stat">
                    <div id="current-seconds" class="current-stat-value">0</div>
                    <div class="current-stat-label">seconds</div>
                </div>
                <div class="current-stat">
                    <div id="current-clicks" class="current-stat-value">0</div>
                    <div class="current-stat-label">clicks</div>
                </div>
                <div class="current-stat">
                    <div id="current-points" class="current-stat-value">0</div>
                    <div class="current-stat-label">points</div>
                </div>
            </div>

            <div id="table-of-contents-container">
                <h3>Contents</h3>
                <div id="table-of-contents"></div>
            </div>
        </aside>
        <section id="game-content" class="content"> </section>
    </section>

    <section id="win" class="page">
        <aside></aside>
        <section class="content">
            <h1>Congratulations!</h1>
        </section>
    </section>

    <?php echo file_get_contents('images/jigsaw-clips.svg'); ?>
</body>
</html>