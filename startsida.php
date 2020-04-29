<?php

$x = 0;

$startpageHeading = '<h1 class="startpageHeading">Vårens bästsäljare</h1>';
$productContainer = '<div class="productContainer">';

$sql = "SELECT * FROM products";
$stmt = $db->prepare($sql);
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

  $sql2 = "SELECT image FROM product_images WHERE product_id = :product_id";
  $stmt2 = $db->prepare($sql2);
  $stmt2->bindParam(":product_id", $row["id"]);
  $stmt2->execute();

  $id     = $row['id'];
  $name   = $row['name'];        
  $price  = $row['price'];
  $image = $stmt2->rowCount() ? $stmt2->fetch(PDO::FETCH_ASSOC)['image'] : "";
  $imgUrl = "./images/$image";


  $productContainer .= "<ul class='product-ul'>
                          <a href='product.php?id=$id' class='product-link'>
                            <li class='product-li'><img src=$imgUrl></li>
                            <li class='product-li product-li-name'><h3>$name</h3></li>
                            <li class='product-li product-li-price'>$price kr</li>
                          </a>
                          <button class='addToCartBtn' data-id='$id' data-image='$imgUrl' data-name='$name' data-price='$price' data-stock='$row[stock]' class='addToCartBtn'>Lägg till i varukorg</button>
                        </ul>";
    
    $x++;

    if ($x >= 9) {
      break;
    }
}
        

$productContainer .= '</div>';

echo $startpageHeading;
echo $productContainer;
?>

<script src="productList.js"></script>