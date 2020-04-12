<?php

require_once "db.php";

if(isset($_GET["q"])) {
    $sql = "SELECT * FROM products WHERE name LIKE CONCAT('%', :q, '%') OR description LIKE CONCAT('%', :q, '%')";
    // OR description LIKE %:q%"
    $productStmt = $db->prepare($sql);
    $productStmt->bindParam(":q", $q);
    $q = $_GET["q"];
    $productStmt->execute();

    $output = "<ul class='list'>";

    while($productRows = $productStmt->fetch(PDO::FETCH_ASSOC)):
        $sql = "SELECT * FROM product_images WHERE product_id = :id";
        $imageStmt = $db->prepare($sql);
        $imageStmt->bindParam(":id", $id);
        $id = $productRows["id"];
        $imageStmt->execute();
        $imageRow = $imageStmt->fetch(PDO::FETCH_ASSOC);
        // echo "<pre>";
        // print_r($imageRow);
        // echo "</pre>";
        $image = $imageRow["image"];
        
        $output .= "<li class='list-item'><a href='product.php?id=$productRows[id]'><h3 class='title'>$productRows[name]</h3>";
        $output .= "<img class='search-img' src='uploads/$image'>";
        $output .= "<span class='price'>$productRows[price]:-</span></a></li>";

    endwhile;

    $output .= "</ul>";

}

require_once "header.php";

echo $output;

require_once "footer.php";

?>