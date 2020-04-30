<?php

require_once "header.php";
require_once "db.php";

$sql = "SELECT * FROM category";
$stmt = $db->prepare($sql);
$stmt->execute();

$get_category = $_GET['category'];

$productContainer = '<div class="productContainer">';

echo "<h2 class='startpageHeading'>". ucfirst($_GET['category']) . "</h2>";


while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

    if ($get_category == $row['category']) {
    $category_id = $row['category_id'];

    $sql = "SELECT * FROM products WHERE stock != 0 AND deleted = 0";
    $stmt2 = $db->prepare($sql);
    $stmt2->execute();

        while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){

            if ($category_id == $row2['category_id']) {

                $sql = "SELECT * FROM product_images";
                $stmt3 = $db->prepare($sql);
                $stmt3->execute();

                while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){

                    

                    if ($row2['id'] == $row3['product_id']) {
                        
                        $name = $row2['name']; 
                    
                        $price = $row2['price'];
                        $id = $row2['id'];
                        $img = "images/" . $row3['image'];
            

                        $productContainer  .=  "<ul class='product-ul'> <a href='product.php?id=$id' class='product-link'>
                            <li class='product-li'><img src=$img></li>
                            <li class='product-li product-li-name'><h3>$name</h3></li>
                            <li class='product-li product-li-price'>$price kr</li>
                            </a></ul>"; 
                            
                        break;


                    }
                }
        
            }
        }
    }
}

$productContainer .= '</div>';

echo $productContainer;

require_once "footer.php";

?>











