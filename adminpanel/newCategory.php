<?php

require_once '../db.php';
require_once 'header.php';

$message = '';

if (isset($_POST['save'])){

    $insert_category = $_POST['category'];

    $sql = "SELECT COUNT(*) AS num FROM category WHERE category = :category";

            $stmt = $db->prepare($sql);
            $stmt->bindValue(':category', $insert_category);
            $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['num'] > 0){
       
        $output = "<div class='newCategoryMessage'>
                        <p class='newCategoryMessage-text'>Denna kategori finns redan.</p>
                        <a href='categories.php'>OK</a>
                        </div>";

        echo $output;

    } else {
       
        $sql = "INSERT INTO category (category)
                SELECT '".$_POST["category"]."' FROM category
                WHERE NOT EXISTS(
                SELECT category FROM category WHERE category = '".$_POST["category"]."'
                ) LIMIT 1
                ";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':category', $category);
                    $stmt->execute();

                        $output = "<div id='newCategoryMessage' class='newCategoryMessage'>
                        <p class='newCategoryMessage-text'>Kategorin är tillagt.</p>
                        <a href='categories.php#category'>OK</a>
                        </div>";
                   
        echo $output;

    } 
}

?>       
        
</div>

<?php require_once 'footer.php'; ?>