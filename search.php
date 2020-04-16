<?php

require_once "db.php";

$url = "http://localhost/Webbshoppen/api.php";
$json = file_get_contents($url);
$jsonArr = json_decode($json, true);

if(isset($_GET["q"])) {

    $filtered = array_filter($jsonArr, function($v, $k) {
        return strpos($v["name"], $_GET["q"]) || strpos($v["description"], $_GET["q"]);
    }, ARRAY_FILTER_USE_BOTH);

    $output = "<div class='productContainer'>";

    foreach($filtered as $value) {
        $output .= "<ul class='product-ul'><a href='product.php?id=$value[id]' class='product-link'>
                    <li class='product-li'><img class='search-img' src=" . $value["images"][0] . "></li>";
        $output .= "<li class='product-li product-li-name'><h3 class='title'>$value[name]</h3></li>";
        $output .= "<li class='product-li product-li-price'> $value[price]kr</li></a></ul>";
    }
    $output .= "</div>";
}

require_once "header.php";

?>

<main>
    <h1 class='startpageHeading'>Du fick <?php echo count($filtered); ?> träffar för "<?php echo $_GET["q"] ?>":</h1>
        <?php echo $output; ?>
</main>

<?php require_once "footer.php"; ?>