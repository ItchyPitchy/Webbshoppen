<?php

require_once "db.php";

$output = "";
$arr = [];

if (isset($_GET["q"])) {
    $q = htmlspecialchars($_GET["q"]);

    if (strlen(trim($q)) >= 2 && strlen(trim($q)) <= 20) {
        $sql = "SELECT id, name, price
                FROM products
                WHERE name LIKE CONCAT('%', :q, '%')";
        $stmt1 = $db->prepare($sql);
        $stmt1->bindParam(":q", $q);
        $stmt1->execute();

        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)):

            $sql = "SELECT image FROM product_images WHERE product_id = :id";
            $stmt2 = $db->prepare($sql);
            $stmt2->bindParam(":id", $row["id"]);
            $stmt2->execute();
            $image = $stmt2->fetch(PDO::FETCH_ASSOC);

            $arr[] = array(
                "id" => $row["id"],
                "name" => $row["name"],
                "price" => $row["price"],
                "image" => $image["image"]
            );

        endwhile;

        foreach ($arr as $value) {
            $output .= 
            "<ul class='product-ul'>
                <a href='product.php?id=$value[id]' class='product-link'>
                    <li class='product-li'><img class='search-img' src=./images/" . $value["image"] . "></li>
                    <li class='product-li product-li-name'><h3 class='title'>$value[name]</h3></li>
                    <li class='product-li product-li-price'>$value[price]kr</li>
                </a>
                <button class='addToCartBtn' data-id='$row[id]' data-image='$image[image]' data-name='$row[name]' data-price='$row[price]' data-stock='$row[stock]' class='addToCartBtn'>Lägg till i varukorg</button>
            </ul>";
        }
    } else {
        $output = "<h2>Fel: Sökordet måste innehålla mellan 2-20 tecken</h2>";
    }
}

require_once "header.php";

?>

<h1 class="startpageHeading">Du fick <?php echo count($arr); ?> träffar för "<?php echo $q ?>":</h1>
<main class="productContainer">
    <?php echo $output; ?>
</main>
<script src="productList.js"></script>
<?php require_once "footer.php"; ?>