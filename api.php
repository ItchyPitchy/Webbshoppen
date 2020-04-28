<?php

$imagesPath = "./images";
require_once "db.php";

$selectProducts = $db->prepare("SELECT * FROM products  INNER JOIN category ON products.category_id=category.category_id ORDER BY id ");
$selectProducts->execute();

$json = [];
while ($productRow = $selectProducts->fetch(PDO::FETCH_ASSOC)) {

    $productId = $productRow['id'];

    // get all images for this product from the db
    $selectImages = $db->prepare("
    SELECT image FROM product_images
    WHERE product_images.product_id = ?
");
$selectImages->execute([$productId]);

    // build an array of file names
    $images = [];
    while ($imgRow = $selectImages->fetch(PDO::FETCH_ASSOC))
    {array_push($images, $imagesPath. '/' .$imgRow['image']);}
    $product = [
        'category' => $productRow['category'],
        'id' => $productRow['id'],
        'name' => $productRow['name'],
        'price' => $productRow['price'],
        'description' => $productRow['description'],
        'stock' => $productRow['stock'],
        'images' => $images,
    ];

    array_push($json, $product);

}

echo json_encode($json);
