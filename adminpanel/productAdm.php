<?php

require_once '../db.php';
require_once 'header.php';

$output = "";

if (isset($_GET['category_id'])):
    
    $sql = "SELECT * FROM products WHERE category_id = :category_id AND deleted = 0";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':category_id', $category_id);
    $category_id = htmlspecialchars($_GET['category_id']);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
    
        $sql2 ="SELECT image FROM product_images WHERE product_id = :product_id";
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam(":product_id", $product_id);
        $product_id = htmlspecialchars($row["id"]);
        $stmt2->execute();

        $id = htmlspecialchars($row['id']);
        $name = htmlspecialchars($row['name']);
        $image = $stmt2->rowCount() ? $stmt2->fetch(PDO::FETCH_ASSOC)["image"] : "";
        $url = "../images/$image";

        $output .= "<tr class='productContainer'>
                    <td class='imgAdm'><img src=$url></td>

                    <td class='admProductName'>$name</td>

                    <td class='admUpdateTd'>
                        <a class='admUpdateBtn' href='updateProduct.php?id=$id'>Redigera </a>
                    </td>

                    <td class='admDeleteTd'>
                        <a class='admDeleteBtn' href='#'>Radera</a>
                    </td>
                </tr>";
    endwhile;


endif;

?>

    <div class='productContainer'>
        <table class='productTable'>
            <thead>
                <tr>
                    <th class='productHead'>Produkter<a class='linkToNewProduct' href="newProduct.php?category_id=<?php echo $category_id; ?>">+</a></th>
                </tr>
            </thead>
            <?php echo $output; ?>
        </table>
    </div>
</div>

<?php require_once 'footer.php'; ?>