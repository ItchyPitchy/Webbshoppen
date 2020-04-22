<?php

$x = 0;

$startpageHeading = '<h1 class="startpageHeading">Vårens bästsäljare</h1>';
$productContainer = '<div class="productContainer">';

  $sql = "SELECT * FROM products";
  $stmt2 = $db->prepare($sql);
  $stmt2->execute();


    while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){

      $sql = "SELECT * FROM product_images";
      $stmt3 = $db->prepare($sql);
      $stmt3->execute();

        while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
                  

          if ($row2['id'] == $row3['product_id']) {
              
              $name   = $row2['name'];        
              $price  = $row2['price'];
              $id     = $row2['id'];
              $img    = "images/" . $row3['image'];
  

              $productContainer  .=  "<ul class='product-ul'> <a href='product.php?id=$id' class='product-link'>
                  <li class='product-li'><img src=$img></li>
                  <li class='product-li product-li-name'><h3>$name</h3></li>
                  <li class='product-li product-li-price'>$price kr</li>
                  </a></ul>";
                  $x++;
                  
          break;


            }
        }
        
        if ($x >= 9) {
          break;
        } 
    }
        

$productContainer .= '</div>';

echo $startpageHeading;
echo $productContainer;
?>

