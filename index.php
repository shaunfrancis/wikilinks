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
            <img id="logo" alt="Wikilinks" src="images/logo.png" />
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
                <button onclick="temp_game()">temp_game</button>
            </section>
        </div>
    </main>

    <section id="game" class="page">
        <section id="game-banner">
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
        </section>
        <aside>
            game aside
        </aside>
        <section id="game-content" class="content">
            
        </section>
    </section>
</body>
</html>