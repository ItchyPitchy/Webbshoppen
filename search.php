<?php

require_once "db.php";

$output = "";
$counter = 0;

if (isset($_GET["q"])) {

    $q = trim(htmlspecialchars($_GET["q"]));

    if (mb_strlen($q) >= 2 && mb_strlen($q) <= 50) {

        $sql = "SELECT id FROM products WHERE deleted = 0 AND stock != 0 ORDER BY create_date asc LIMIT 6";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $saleArr = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)):

            $saleArr[] = $row['id'];
        
        endwhile;
            
        $sql1 = "SELECT * FROM products
                WHERE name LIKE CONCAT('%', :q, '%')
                AND stock != 0 AND deleted = 0";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam(":q", $q);
        $stmt1->execute();

        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)):

            $counter++;
            $sql2 = "SELECT image FROM product_images WHERE product_id = :id";
            $stmt2 = $db->prepare($sql2);
            $stmt2->bindParam(":id", $row1["id"]);
            $stmt2->execute();
            $image = $stmt2->rowCount() ? $stmt2->fetch(PDO::FETCH_ASSOC)["image"] : "";

            if(in_array($row1['id'], $saleArr)){

                $output .= "<ul class='product-ul'>
                                <a href='saleProduct.php?id=$row1[id]' class='product-link'>
                                    <li class='product-li'><img src='./images/$image'></li>
                                    <li class='product-li product-li-name'><h3>$row1[name]</h3></li>
                                    <li class='product-li product-li-sale'>" . ceil($row1['price']*0.9) . "kr</li> 
                                    <li class='product-li product-li-price oldPrice'>
                                        <p>Normalpris:</p>
                                        <span>$row1[price] kr </span>
                                    </li>
                                </a>
                                <button class='addToCartBtn' data-id='$row1[id]' data-image='./images/$image' data-name='$row1[name]' data-price=" . ceil($row1['price']*0.9) . " data-stock='$row1[stock]' class='addToCartBtn'>Lägg till i varukorg</button>
                                </ul>";

            } else {

                $output .= "<ul class='product-ul'>
                                <a href='product.php?id=$row1[id]' class='product-link'>
                                    <li class='product-li'><img class='search-img' src='./images/$image'></li>
                                    <li class='product-li product-li-name'><h3 class='title'>$row1[name]</h3></li>
                                    <li class='product-li product-li-price'>$row1[price]kr</li>
                                </a>
                                <button class='addToCartBtn' data-id='$row1[id]' data-image='./images/$image' data-name='$row1[name]' data-price='$row1[price]' data-stock='$row1[stock]' class='addToCartBtn'>Lägg till i varukorg</button>
                            </ul>";
            }
        endwhile;
    } else {
        $output = "<h2>Fel: Sökordet måste innehålla mellan 2-50 tecken</h2>";
    }
}

require_once "header.php";

?>

<h1 class="startpageHeading">Du fick <?php echo $counter; ?> träffar för "<?php echo $q; ?>":</h1>
<main class="productContainer">
    <?php echo $output; ?>
</main>
<script src="productList.js"></script>
<?php require_once "footer.php"; ?>