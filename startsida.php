<?php

$x = 0;

$startpageHeading = '<h1 class="startpageHeading">Vårens bästsäljare</h1>';
$productContainer = '<div class="productContainer">';

$sql = "SELECT * FROM products";
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

$startpageHeading2 = '<a class="navigation-link" href="newCome.php"><h1 class="startpageHeading">Nyinkommet</h1></a>';
$productContainer2 = '<div class="productContainer">';

$sql = "SELECT * FROM products ORDER BY create_date desc LIMIT 3";
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


