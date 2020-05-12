<?php

require_once '../db.php';
require_once 'header.php';

$message = '';

if (isset($_POST["category"]) && isset($_POST["update_id"])) {
    $newCat = htmlspecialchars($_POST["category"]);
    $oldCatID = htmlspecialchars($_POST["update_id"]);

    $sql = "SELECT * FROM category WHERE category = :category";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":category", $newCat);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        $sql2 = "UPDATE category SET category = :category WHERE category_id = :update_id";
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam(":category", $newCat);
        $stmt2->bindParam(":update_id", $oldCatID);
        $stmt2->execute();

        $output = "<div id='newCategoryMessage' class='newCategoryMessage'>
                        <p class='newCategoryMessage-text'>Kategorin är uppdaterad.</p>
                        <a href='categories.php#category'>OK</a>
                    </div>";
                   
                 echo $output;
    } else {
        $output = "<div class='newCategoryMessage'>
                        <p class='newCategoryMessage-text'>Denna kategori finns redan.</p>
                        <a href='categories.php'>OK</a>
                    </div>";

        echo $output;
    }
}

?>       

</div>

<?php require_once 'footer.php'; ?>