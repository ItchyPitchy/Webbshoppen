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

            $saleArr = [];

            $sql4 = "SELECT id FROM products WHERE deleted = 0 AND stock != 0 ORDER BY create_date asc LIMIT 6";
            $stmt4 = $db->prepare($sql4);
            $stmt4->execute();

            while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)):

                $saleArr[] = $row4["id"];

            endwhile;
        
            $sql3 = "SELECT image FROM product_images WHERE product_id = :product_id";
            $stmt3 = $db->prepare($sql3);
            $stmt3->bindParam(":product_id", $product_id);
            $product_id = htmlspecialchars($row2["id"]);
            $stmt3->execute();

            $image = $stmt3->rowCount() ? $stmt3->fetch(PDO::FETCH_ASSOC)["image"] : "";
            $imgUrl = "./images/$image";

            if (in_array($row2["id"], $saleArr)) {

                $output .= "<ul class='product-ul'>
                                <a href='saleProduct.php?id=$row2[id]' class='product-link'>
                                    <li class='product-li'><img src=$imgUrl></li>
                                    <li class='product-li product-li-name'><h3>$row2[name]</h3></li>
                                    <li class='product-li product-li-sale'>" . ceil($row2["price"]*0.9) . " kr</li>
                                    <li class='product-li product-li-price oldPrice'>
                                        <p>Normalpris:</p>
                                        <span>$row2[price] kr</span>
                                    </li>
                                    <button class='addToCartBtn product-li product-li-buy' data-id='$row2[id]' data-image='$imgUrl' data-name='$row2[name]' data-price='" . ceil($row2["price"]*0.9) . "' data-stock='$row2[stock]' class='addToCartBtn'>Lägg till i varukorg</button>
                                </a>
                            </ul>";

            } else {

                $output .= "<ul class='product-ul'>
                                <a href='product.php?id=$row2[id]' class='product-link'>
                                    <li class='product-li'><img src='$imgUrl'></li>
                                    <li class='product-li product-li-name'><h3>$row2[name]</h3></li>
                                    <li class='product-li product-li-price'>$row2[price] kr</li>
                                </a>
                                <button class='addToCartBtn product-li product-li-buy' data-id='$row2[id]' data-image='$imgUrl' data-name='$row2[name]' data-price='$row2[price]' data-stock='$row2[stock]' class='addToCartBtn'>Lägg till i varukorg</button>
                            </ul>";
            }

        endwhile;

        $output .= "</div>";

    } else {

        $output .= "<h2 class='startpageHeading'>Kategorin hittades inte</h2>";
    }

} else {

    $output .= "<h2 class='startpageHeading'>Kategorin hittades inte</h2>";

}

echo $output;

?>

<script src="productList.js"></script>

<?php require_once "footer.php"; ?>