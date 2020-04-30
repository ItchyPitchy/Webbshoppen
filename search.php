<?php

require_once "db.php";

$output = "";
$arr = [];

if (isset($_GET["q"])) {

    $q = trim(htmlspecialchars($_GET["q"]));

    if (mb_strlen($q) >= 2 && mb_strlen($q) <= 50) {
        $sql1 = "SELECT * FROM products
                WHERE name LIKE CONCAT('%', :q, '%')
                AND stock != 0 AND deleted = 0";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam(":q", $q);
        $stmt1->execute();

        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)):

            $sql2 = "SELECT image FROM product_images WHERE product_id = :id";
            $stmt2 = $db->prepare($sql2);
            $stmt2->bindParam(":id", $row["id"]);
            $stmt2->execute();
            $image = $stmt2->rowCount() ? $stmt2->fetch(PDO::FETCH_ASSOC)["image"] : "";
    
            $output .= "<ul class='product-ul'>
                            <a href='product.php?id=$row[id]' class='product-link'>
                                <li class='product-li'><img class='search-img' src='./images/$image'></li>
                                <li class='product-li product-li-name'><h3 class='title'>$row[name]</h3></li>
                                <li class='product-li product-li-price'>$row[price]kr</li>
                            </a>
                            <button class='addToCartBtn' data-id='$row[id]' data-image='./images/$image' data-name='$row[name]' data-price='$row[price]' data-stock='$row[stock]' class='addToCartBtn'>Lägg till i varukorg</button>
                        </ul>";

        endwhile;
    } else {
        $output = "<h2>Fel: Sökordet måste innehålla mellan 2-50 tecken</h2>";
    }
}

require_once "header.php";

?>

<h1 class="startpageHeading">Du fick <?php echo count($arr); ?> träffar för "<?php echo $q; ?>":</h1>
<main class="productContainer">
    <?php echo $output; ?>
</main>
<script src="productList.js"></script>
<?php require_once "footer.php"; ?>