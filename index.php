<?php include '../scripts/ini.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles/app.css" />
    <script type="text/javascript" src="app.js"></script>
    <title>Wikilinks - The Wikipedia Racing Game! - Tennessine</title>
</head>
<body>
    <?php $external_header = TRUE; include '../components/header.php'; ?>

    <main class="page visible">
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
            </section>
        </div>
    </main>

    <section id="game" class="page visible">
        <aside>
            game aside
        </aside>
        <section id="game-content" class="content">
            game-content
        </section>
    </section>

</body>
</html>