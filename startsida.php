<?php

$url = "http://localhost/Webbshoppen/api.php";

$json = file_get_contents($url);

$jsonArr = json_decode($json, true);

$startpageHeading = '<h1 class="startpageHeading">Vårens bästsäljare</h1>';
$productContainer = '<div class="product-link"><div class="productContainer">';


for ($x = 0; $x < 9; $x++ ) {

        $name = $jsonArr[$x]['name'];
        $price = $jsonArr[$x]['price'];
        $img = $jsonArr[$x]['images'][0];

        $productContainer  .=  " <ul class='product-ul'> <a href='http://example.com' class='product-link'>
          <li class='product-li'><img src=$img></li>
          <li class='product-li product-li-name'><h3>$name</h3></li>
          <li class='product-li product-li-price'>$price kr</li>
          </a></ul>";    

}





$productContainer .= '</div></a>';

echo $startpageHeading;
echo $productContainer;

?>