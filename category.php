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

    $sql = "SELECT * FROM products";
    $stmt1 = $db->prepare($sql);
    $stmt1->execute();
    $antal = $stmt1->rowcount();
    $tot = $antal-6;

    $sql = "SELECT * FROM products WHERE stock != 0 AND deleted = 0 ORDER BY create_date desc LIMIT 0, $tot";
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

        $sql = "SELECT * FROM products WHERE deleted = 0 AND stock != 0 ORDER BY create_date asc LIMIT 6";
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
                        $sale_price = ceil($price*0.9);
    
                        $productContainer  .=  "<ul class='product-ul'> <a href='product.php?id=$id' class='product-link'>
                                                    <li class='product-li'><img src=$img></li>
                                                    <li class='product-li product-li-name'><h3>$name</h3></li>
                                                    <li class='product-li product-li-sale'>$sale_price :- </li>
                                                    <li class='product-li product-li-price oldPrice'>
                                                        <p>Normalpris:</p>
                                                        <span>$price kr </span></li>
                                                    <button class='product-li product-li-buy addToCartBtn'>Köp</button>
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











