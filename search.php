<?php

require_once "header.php";
require_once "db.php";

if(isset($_GET["q"])) {
    $sql = "SELECT * FROM products WHERE name LIKE CONCAT('%', :q, '%') OR description LIKE CONCAT('%', :q, '%')";
    // OR description LIKE %:q%"
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":q", $q);
    $q = $_GET["q"];
    $stmt->execute();

    $output = "<ul>";

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)):
        $output .= "<li><h3>$row[name]</h3></li>";
        $output .= "<li><p>$row[description]</p></li>";

    endwhile;

    $output .= "</ul>";
    echo $output;

}

require_once "footer.php";

?>