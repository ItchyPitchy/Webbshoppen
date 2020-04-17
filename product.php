<?php
require_once 'header.php';

$id = htmlspecialchars($_GET['id']);
$url = "http://localhost/Webbshoppen/api.php";


$json = file_get_contents($url);
$jsonArr = json_decode($json, true);

$product = '';
for($i=0; $i < count($jsonArr); $i++) {

    if($jsonArr[$i]['id'] == $id){
        $product = $jsonArr[$i];
    }
}

    $id = $product['id'];
    $name = $product['name'];
    $description = $product['description'];
    $price = $product['price'];
    $stock = $product['stock'];
    $img = $product['images'];
 
$productContainer = "<main><section class='productContainer1'><div class='imgContainer'>";

foreach ($img as $key => $value) {
    $productContainer .= "<div class='mySlides fade'>
                            <img src='$value' alt='Produkt bild'>
                         </div>";
}
$productContainer .= "<a class='prev'>&#10094;</a>
                      <a class='next'>&#10095;</a>";
$productContainer .= '</div>';

$productContainer .= "<article class='productInfo'>
                        <h1 class='productName'>$name</h1>
                        <p class='productInfo__description'>$description</p>
                        <p class='productInfo__price'>$price Kr</p>
                        <p class='productInfo__stock'>$stock st finns i lager</p>
                        <input type='num' id='qtyInput' class='quantityInput' value='1' placeholder='ange antal'>
                        <span id='stock-alert' class='hide'>Out of stock :P</span>
                        <br>
                        <button id='addBtn' type='submit'class='addToCartBtn'>Lägg till i varukorg</button>
                    </article>
                </section>
            </main>";    

echo $productContainer;
require_once 'footer.php';
?>

<script>
let prev = document.querySelector(".prev");
prev.addEventListener("click", function(){
    plusSlides(-1);
});

let next = document.querySelector(".next");
next.addEventListener("click", function(){
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
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  slides[slideIndex-1].style.display = "block";
}
</script>
<script src="product.js"></script>
