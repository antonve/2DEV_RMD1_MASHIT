<?php

// helpers.php - contains some useful functions
// By Anton Van Eechaute

function trace($data)
{
    echo '<pre class="debug_trace">';
    var_dump($data);
    echo '</pre>';
}

function autop($text)
{
    $text = str_replace("\r\n","\n",$text);

    $paragraphs = preg_split("/[\n]{2,}/",$text);
    foreach ($paragraphs as $key => $p) {
        $paragraphs[$key] = "<p>".str_replace("\n","<br />",$paragraphs[$key])."</p>";
    }

    $text = implode("", $paragraphs);

    return $text;
}
