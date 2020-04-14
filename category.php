<?php

require_once "header.php";

$url = "http://localhost/Webbshoppen/api.php";

$json = file_get_contents($url);

$jsonArr = json_decode($json, true);

$get_category = $_GET['category'];

$productContainer = '<div class="product-link"><div class="productContainer">';

echo "<h2 class='startpageHeading'>". $_GET['kategori'] . "</h2>";

for ($x = 0; $x < sizeof($jsonArr); $x++ ) {

    if ($jsonArr[$x]['category'] == $get_category) {
        

        $name = $jsonArr[$x]['name'];
        $price = $jsonArr[$x]['price'];
        $stock = $jsonArr[$x]['stock'];
        $img = $jsonArr[$x]['images'][0];
        $id = $jsonArr[$x]['id'];


        $productContainer  .=  " <a href='product.php?id=$id' class='product-link'> <ul class='product-ul'>
          <li class='product-li'><img src=$img></li>
          <li class='product-li product-li-name'><h3>$name</h3></li>
          <li class='product-li product-li-price'>$price kr</li>
        </ul></a>";   

    }

}


$productContainer .= '</div></a>';

echo $productContainer;

require_once "footer.php";

?>











