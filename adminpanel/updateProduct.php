<?php
require_once 'header.php';
require_once 'db.php';

$id = isset($_GET['id']) ? $_GET['id'] : die();

$sql = "SELECT * FROM products WHERE id= :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

if ($stmt->rowcount() !== 0) {

    $row = $stmt->fetch(PDO::FETCH_ASSOC);  
    $name = htmlspecialchars($row['name']);
    $description = htmlspecialchars($row['description']);
    $price = htmlspecialchars($row['price']);
    $stock = htmlspecialchars($row['stock']);
    $productId = htmlspecialchars($row['id']);

    $sql1 = " SELECT image FROM product_images WHERE product_images.product_id = ? ";
    $selectImages = $db->prepare($sql1);
    $selectImages->execute([$productId]);

    $images = [];

    while ($imgRow = $selectImages->fetch(PDO::FETCH_ASSOC)) { 
            array_push($images, $imgRow['image']);
    }


} else {
    header('Location:index.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


  
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $stock = htmlspecialchars($_POST['stock']);
    $price = htmlspecialchars($_POST['price']); 
    $product_id = htmlspecialchars($_GET['id']);

    $sql = "UPDATE products
          SET name = :name, description = :description , stock=:stock ,price=:price
          WHERE id = :id";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':id', $product_id);

    $stmt->execute();
    //header('Location:index.php');
    //exit;
    header('Location:#popup1');


} 



    ?>
<div class="divProductForm">
<form action="#" method="POST" class="updateProductForm" enctype="multipart/form-data">
<div>
<label class="updateProductFormTitle">Uppdatera produkt</label>
</div>
<div class="">
        <label class="labelsss" for="name">Produkts namn:</label>
        <input name="name" type="text" maxlength="100" autofocus required class="updateProductGroupForm" value="<?php echo $name ?>" >
    </div>
    <div>
        <label class="labelsss" for="description">Beskrivning:</label>
        <textarea name="description" value="<?php echo $description ?>" rows="3" maxlength="600" class="updateProductGroupForm" ><?php echo $description ?></textarea>
    </div>
    <div>
        <label class="labelsss" for="stock">Antal i lager:</label>
        <input id="stock" type="number"value="<?php echo $stock ?>" name="stock" min="0"  class="updateProductGroupForm" placeholder="">
    </div>
    <div>
        <label class="labelsss" for="price">pris:</label>
        <input name="price" type="number"value="<?php echo $price ?>" min="0" class="updateProductGroupForm">
    </div>

    <div>
        <input type="submit" value="Uppdatera" class="productConfirmBtnnn"> 
    </div>
    <input type="hidden" name="id" value="<?php echo $id; ?>">
</form>



<form action="updateImage.php" method="POST" class="productForms" enctype="multipart/form-data">
<div>
        <label class="labelsss" for="image">Ladda upp nya bilder på produkten! (MAX 5)</label>
        <input type='file' class="updateProductGroupForm" name='files[]' multiple />
    </div>
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div>
        <input type="submit" value="Uppdatera bilderna" class="productConfirmBtnnn"> 
    </div>
</form>

</div>




<?php /*
<div class="box">
    <a class="button" href="#popup1">Let me Pop up</a>
</div>   href="index.php"  */ 
?>
<div id="popup1" class="overlay">
    <div class="popup">
        <h2>Produkten är uppdaterad.</h2>
        <a class="close" href="">OK</a>
        <div class="content">
       
        </div>
    </div>
</div>

<?php require_once "./footer.php";  ?>