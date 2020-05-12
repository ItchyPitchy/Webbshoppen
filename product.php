<?php

require_once 'header.php';
require_once 'db.php';

$id = isset($_GET['id']) ? $_GET['id'] : die();

$sql = "SELECT * FROM products WHERE id= :id AND stock != 0 AND deleted = 0";
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
        
    $productContainer = "<main>
                        <section class='productContainer1'>
                            <div class='imgContainer'>";

    foreach ($images as $value) {
        $productContainer .= "<div class='mySlides fade'>
                            <img class='search-img' src='./images/$value'>
                         </div>";
    }
    $productContainer .= "<a class='prev'>&#10094;</a>
                      <a class='next'>&#10095;</a></div>
                    <article class='productInfo'>
                        <h1 class='productName'>$name</h1>
                        <p class='productInfo__description'>$description</p>
                        <p class='productInfo__price'><span id='price'>$price</span> Kr</p>
                        <p class='productInfo__stock'><span id='stock'>$stock</span> st finns i lager</p>
                        <input type='num' id='qtyInput' class='quantityInput' value='1' placeholder='ange antal'>
                        <br>
                        <button id='addBtn' type='submit' class='addToCartBtn'>Lägg till i varukorg</button>
                        <span id='stockAlert' class='hide'>Din order överskrider lagerstatus</span>
                        <span id='maxLimitAlert' class='hide'>Maxgränsen är nådd</span>
                    </article>
                </section>
            </main>";

    echo $productContainer;
} else {
    echo '<h2>Produkten du söker kan inte hittas</h2>';
}
require_once 'footer.php';
?>

<script>
    let prev = document.querySelector(".prev");
    prev.addEventListener("click", function() {
        plusSlides(-1);
    });

    let next = document.querySelector(".next");
    next.addEventListener("click", function() {
        plusSlides(1);
    });

    let slideIndex = 1;
    showSlides(slideIndex);
    // Next/previous controls
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slides[slideIndex - 1].style.display = "block";
    }
</script>
<script src="product.js"></script>