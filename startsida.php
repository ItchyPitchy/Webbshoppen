<?php

$x = 0;

$startpageHeading = '<h1 class="startpageHeading">Vårens bästsäljare</h1>';
$productContainer = '<div class="productContainer">';

$sql = "SELECT * FROM products WHERE stock != 0 AND deleted = 0";
$stmt2 = $db->prepare($sql);
$stmt2->execute();

while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){

  $sql = "SELECT image FROM product_images WHERE product_id = :product_id";
  $stmt3 = $db->prepare($sql);
  $stmt3->bindParam(":product_id", $row2["id"]);
  $stmt3->execute();

  $name   = $row2['name'];        
  $price  = $row2['price'];
  $id     = $row2['id'];
  $img    = "images/" . $stmt3->fetch(PDO::FETCH_ASSOC)['image'];


  $productContainer .= "<ul class='product-ul'> <a href='product.php?id=$id' class='product-link'>
      <li class='product-li'><img src=$img></li>
      <li class='product-li product-li-name'><h3>$name</h3></li>
      <li class='product-li product-li-price'>$price kr</li>
      </a></ul>";
    
    $x++;

    if ($x >= 9) {
      break;
    }
}
        

$productContainer .= '</div>';

echo $startpageHeading;
echo $productContainer;
?>

<?php
$y = 0;

$startpageHeading2 ='<h1 class="titleNew"><a class="titleNewLink" href="newCome.php">Nyinkommet</a></h1>';
$productContainer2 = '<div class="productContainer">';

$sql = "SELECT * FROM products WHERE stock != 0 AND deleted = 0 ORDER BY create_date desc LIMIT 3";
$stmt2 = $db->prepare($sql);
$stmt2->execute();

while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){

  $sql = "SELECT image FROM product_images WHERE product_id = :product_id";
  $stmt3 = $db->prepare($sql);
  $stmt3->bindParam(":product_id", $row2["id"]);
  $stmt3->execute();

  $name   = $row2['name'];        
  $price  = $row2['price'];
  $id     = $row2['id'];
  $time     = $row2['create_date'];
  $img    = "images/" . $stmt3->fetch(PDO::FETCH_ASSOC)['image'];


  $productContainer2 .= "<ul class='product-ul'> <a href='product.php?id=$id' class='product-link'>
      <li class='product-li'><img src=$img></li>
      <li class='product-li product-li-name'><h3>$name</h3></li>
      <li class='product-li product-li-price'>$price kr</li>
      </a></ul>";
    
    $x++;

    if ($y >= 3) {
      break;
    }
}
$productContainer2 .= '</div>';

echo $startpageHeading2;
echo $productContainer2;
?>

<?php  

$startpageHeading3 ='<h1 class="titleNew lastChanceHeading"><a class="titleNewLink" href="lastChance.php">Sista chansen</a></h1>';
$productContainer3 = '<div class="productContainer">';

$sql = "SELECT * FROM products WHERE deleted = 0 AND stock != 0 ORDER BY create_date asc LIMIT 3";
$stmt = $db->prepare($sql);
$stmt->execute();


while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

  $sql = "SELECT image FROM product_images WHERE product_id = :product_id";
  $stmt2 = $db->prepare($sql);
  $stmt2->bindParam(":product_id", $row["id"]);
  $stmt2->execute();
  
  $name   = $row['name'];        
  $price  = $row['price'];
  $id     = $row['id'];
  $create_date = $row['create_date'];
  $img    = "images/" . $stmt2->fetch(PDO::FETCH_ASSOC)['image'];
  $sale_price = ceil($price*0.9);

  $productContainer3 .= "<ul class='product-ul'> <a href='product.php?id=$id' class='product-link'>
      <li class='product-li'><img src=$img></li>
      <li class='product-li product-li-name'><h3>$name</h3></li>
      <li class='product-li product-li-sale'>$sale_price :- </li>
      <li class='product-li product-li-price oldPrice'>
        <p>Normalpris:</p>
        <span>$price kr </span></li>
      <button class='product-li product-li-buy addToCartBtn'>Köp</button>
      </a></ul>";
 
}
$productContainer3 .= '</div>';

echo $startpageHeading3;
echo $productContainer3;
?>

