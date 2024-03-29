<?php
    include 'scripts/db.php';

    $dsn = "mysql:host={$db_host};dbname={$db_database};charset=utf8mb4";
    $pdo = new PDO($dsn, $db_user, $db_password);

    /*$stmt = $pdo -> prepare("SELECT initial, goal FROM daily_games ORDER BY date DESC LIMIT 1");
    $stmt -> execute();
    $todays_game = $stmt -> fetch();*/
        $stmt = $pdo -> prepare("SELECT title FROM articles ORDER BY RAND() LIMIT 2");
        $stmt -> execute();
        $x = $stmt -> fetch();
        $todays_initial = str_replace("_", " ", $x["title"]);
        $x = $stmt -> fetch();
        $todays_goal = str_replace("_", " ", $x["title"]);
        $todays_game = array("initial" => $todays_initial, "goal" => $todays_goal);


    //IN FUTURE THESE IMAGES WILL BE STORED IN DAILY TABLE GENERATED BY NODE SERVER EACH DAY
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://en.wikipedia.org/w/api.php?origin=*&action=query&prop=pageimages&piprop=thumbnail&pithumbsize=500&pilicense=any&format=json&redirects=true&titles=' . urlencode($todays_game['initial']) . '|' . urlencode($todays_game['goal']));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Wikilinks/2.0 (https://tennessine.co.uk/wikilinks; hello@tennessine.co.uk)');

    $todays_images = curl_exec($ch);
    $todays_images = json_decode($todays_images, TRUE);
    curl_close($ch);

    $keys = array_keys($todays_images["query"]["pages"]);
    $todays_game["initial_image"] = $todays_images["query"]["pages"][$keys[0]]["thumbnail"]["source"];
    $todays_game["target_image"] = $todays_images["query"]["pages"][$keys[1]]["thumbnail"]["source"];
?>