<?php

require_once "header.php";
require_once "db.php";

$output = "";

if (isset($_GET["category"])) {

    $category_id = htmlspecialchars($_GET["category"]);

    $sql1 = "SELECT category FROM category WHERE category_id = :category_id";
    $stmt1 = $db->prepare($sql1);
    $stmt1->bindParam(":category_id", $category_id);
    $stmt1->execute();

    if ($stmt1->rowCount() !== 0) {

        $output .= "<h2 class='startpageHeading'>" . ucfirst($stmt1->fetch(PDO::FETCH_ASSOC)["category"]) . "</h2><div class='productContainer'>";
        
        $sql2 = "SELECT * FROM products WHERE category_id = :category_id";
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam(":category_id", $category_id);
        $stmt2->execute();

        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)):
        
            $sql3 = "SELECT image FROM product_images WHERE product_id = :product_id";
            $stmt3 = $db->prepare($sql3);
            $stmt3->bindParam(":product_id", $product_id);
            $product_id = htmlspecialchars($row2["id"]);
            $stmt3->execute();

            $image = $stmt3->rowCount() ? $stmt3->fetch(PDO::FETCH_ASSOC)["image"] : "";
            $imgUrl = "./images/$image";

            $output .= "<ul class='product-ul'>
                            <a href='product.php?id=$row2[id]' class='product-link'>
                                <li class='product-li'><img src='$imgUrl'></li>
                                <li class='product-li product-li-name'><h3>$row2[name]</h3></li>
                                <li class='product-li product-li-price'>$row2[price] kr</li>
                            </a>
                            <button class='addToCartBtn' data-id='$row2[id]' data-image='$imgUrl' data-name='$row2[name]' data-price='$row2[price]' data-stock='$row2[stock]' class='addToCartBtn'>Lägg till i varukorg</button>
                        </ul>"; 

        endwhile;

        $output .= "</div>";

    } else {

        $output .= "<h2 class='startpageHeading'>Kategorin hittades inte</h2>";
    }

} else {

    $output .= "<h2 class='startpageHeading'>Kategorin hittades inte</h2>";

}

echo $output;

// $sql = "SELECT * FROM category";
// $stmt = $db->prepare($sql);
// $stmt->execute();

// $get_category = $_GET['category'];

// $productContainer = '<div class="productContainer">';

// echo "<h2 class='startpageHeading'>". ucfirst($_GET['category']) . "</h2>";


// while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

//     if ($get_category == $row['category']) {
//     $category_id = $row['category_id'];

//     $sql = "SELECT * FROM products WHERE stock != 0 AND deleted = 0";
//     $stmt2 = $db->prepare($sql);
//     $stmt2->execute();

//         while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){

//             if ($category_id == $row2['category_id']) {

//                 $sql = "SELECT * FROM product_images";
//                 $stmt3 = $db->prepare($sql);
//                 $stmt3->execute();

//                 while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){

                    

//                     if ($row2['id'] == $row3['product_id']) {
                        
//                         $name = $row2['name']; 
                    
//                         $price = $row2['price'];
//                         $id = $row2['id'];
//                         $img = "images/" . $row3['image'];
            

//                         $productContainer  .=  "<ul class='product-ul'> <a href='product.php?id=$id' class='product-link'>
//                             <li class='product-li'><img src='./images/$img'></li>
//                             <li class='product-li product-li-name'><h3>$name</h3></li>
//                             <li class='product-li product-li-price'>$price kr</li>
//                             </a>
//                             <button class='addToCartBtn' data-id='$row2[id]' data-image='./images/$image' data-name='$row[name]' data-price='$row[price]' data-stock='$row[stock]' class='addToCartBtn'>Lägg till i varukorg</button>
//                             </ul>"; 
                            
//                         break;


//                     }
//                 }
        
//             }
//         }
//     }
// }

// $productContainer .= '</div>';

// echo $productContainer;
?>

<script src="productList.js"></script>

<?php require_once "footer.php"; ?>