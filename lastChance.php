<?php
require_once 'db.php';
require_once 'header.php';

$startpageHeading = '<h1 class="startpageHeading lastChanceHeading" >Sista chansen</h1>';
$productContainer = '<div class="productContainer">';

$sql = "SELECT * FROM products WHERE deleted = 0 AND stock != 0 ORDER BY create_date asc LIMIT 6";
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

  $productContainer .= "<ul class='product-ul'> <a href='saleProduct.php?id=$id' class='product-link'>
      <li class='product-li'><img src=$img></li>
      <li class='product-li product-li-name'><h3>$name</h3></li>
      <li class='product-li product-li-sale'>$sale_price :- </li>
      <li class='product-li product-li-price oldPrice'>
        <p>Normalpris:</p>
        <span>$price kr </span></li>
      </a>
      <button class='addToCartBtn' data-id='$id' data-image='$img' data-name='$name' data-price='$sale_price' data-stock='$row[stock]' class='addToCartBtn'>Lägg till i varukorg</button>
      </ul>";
 
}
$productContainer .= '</div>';

echo $startpageHeading;
echo $productContainer;
?>

<?php
require_once 'footer.php';
?>

<script src="productList.js"></script>