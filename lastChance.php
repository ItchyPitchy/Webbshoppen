<?php
require_once 'db.php';
require_once 'header.php';




$startpageHeading = '<h1 class="startpageHeading lastChanceHeading" >Sista chansen</h1>';
$productContainer = '<div class="productContainer">';

$sql = "SELECT * FROM products WHERE deleted = 0 AND stock != 0 ORDER BY create_date asc LIMIT 6 ";
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
  $create_date = $row2['create_date'];
  $img    = "images/" . $stmt3->fetch(PDO::FETCH_ASSOC)['image'];
  $sale_price = ceil($price*0.9);

  $productContainer .= "<ul class='product-ul'> <a href='product.php?id=$id' class='product-link'>
      <li class='product-li'><img src=$img></li>
      <li class='product-li product-li-name'><h3>$name</h3></li>
      <li class='product-li product-li-sale'>$sale_price :- </li>
      <li class='product-li product-li-price oldPrice'>
        <p>Normalpris:</p>
        <span>$price kr </span></li>
      <button class='product-li product-li-buy addToCartBtn'>Köp</button>
      </a></ul>";
    
   
}
        

$productContainer .= '</div>';

echo $startpageHeading;
echo $productContainer;
?>












<?php
require_once 'footer.php';
?>