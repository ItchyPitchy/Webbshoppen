<?php
/*********
 * 
 *     skapar ett api för den valda produkten
 * 
 */

 require_once 'db.php';
 
 $id = isset($_GET['id']) ? $_GET['id'] : die();
 
 $sql = "SELECT * FROM products WHERE id= :id"; 
 $stmt = $db->prepare($sql);
 $stmt->bindParam(':id', $id);
 $stmt->execute();

 $json = [];
 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $productId = $row['id'];
    
    $selectImages = $db->prepare("
    SELECT image FROM product_images
    WHERE product_images.product_id = ?
");
$selectImages->execute([$productId]);

$imagesPath = "./images";

$images = [];
while ($imgRow = $selectImages->fetch(PDO::FETCH_ASSOC))

{array_push($images, $imagesPath. '/' .$imgRow['image']);}

$product = [
    'id' => $row['id'],
    'name' => $row['name'],
    'price' => $row['price'],
    'description' => $row['description'],
    'stock' => $row['stock'],
    'images' => $images,
];
array_push($json, $product);
}
 echo json_encode($json);
 ?>

