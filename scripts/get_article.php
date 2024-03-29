<?php
    header("Content-Type: text/plain");
    if(empty($_GET['title'])) exit('{"status":400}');

    $title = $_GET['title'];
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://en.wikipedia.org/w/api.php?origin=*&action=parse&prop=text&format=json&redirects=true&page=' . urlencode($title));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Wikilinks/2.0 (https://tennessine.co.uk/wikilinks; hello@tennessine.co.uk)');

    $result = curl_exec($ch);
    curl_close($ch);

    if(!$result) exit('{"status":500}');

    $result = json_decode($result, TRUE);
    if(!result) exit('{"status":500}');

    if(isset($result['error']) && $result['error']['code'] == "missingtitle") exit('{"status":404}');
    else if(isset($result['error'])) exit('{"status":500}');
    else exit('{"status":200, "title":' . json_encode($result['parse']['title']) . ', "content":' . json_encode($result['parse']['text']['*']) . '}');
?>