<?php

require_once "db.php";

$url = "http://localhost/Webbshoppen/api.php";
$json = file_get_contents($url);
$jsonArr = json_decode($json, true);

if(isset($_GET["q"])) {

    $filtered = array_filter($jsonArr, function($v, $k) {
        return strpos($v["name"], $_GET["q"]) || strpos($v["description"], $_GET["q"]);
    }, ARRAY_FILTER_USE_BOTH);

    $output = "<ul class='list'>"; 

    foreach($filtered as $value) {
        $output .= "<li class='list-item'><a href='product.php?id=$value[id]'><h3 class='title'>$value[name]</h3>";
        $output .= "<img class='search-img' src=" . $value["images"][0] . ">";
        $output .= "<span class='price'>$value[price]:-</span></a></li>";
    }

    $output .= "</ul>";
}

require_once "header.php";

echo $output;

require_once "footer.php";

?>