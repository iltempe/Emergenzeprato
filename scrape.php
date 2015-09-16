<?php
    $page = file_get_contents('http://www.protezionecivile.comune.prato.it/emergenze/');
    $doc = new DOMDocument();
    $doc->loadHTML($page);
    $node = $doc->getElementById('div.contenitore');
    echo $doc->saveHtml($node), PHP_EOL;
?>