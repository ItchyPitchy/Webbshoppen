<?php
require_once 'header.php';

$id = htmlspecialchars($_GET['id']);
$url = "http://localhost/Webbshoppen/fetchProduct.php?id=" . $id;

$json = file_get_contents($url);
$jsonArr = json_decode($json, true);

    $id = $jsonArr[0]['id'];
    $name = $jsonArr[0]['name'];
    $description = $jsonArr[0]['description'];
    $price = $jsonArr[0]['price'];
    $stock = $jsonArr[0]['stock'];
    $img = $jsonArr[0]['images'];
 
$productContainer = "<main><section><div class='imgContainer'>";

foreach ($img as $key => $value) {
    $productContainer .= "<div>
                            <img src='$value' alt='' width='100' height='100' >
                        </div>";
}
$productContainer .= '</div>';

$productContainer .= "<article>
                        <h1>$name</h1>
                        <p>$description</p>
                        <p>$price Kr</p>
                        <br>
                        <p>$stock st finns i lager</p>
                        <br>
                        <input type='num' id='quantityInput'>
                        <button id='' type='submit'>Lägg till i varukorg</button>
                    </article>
                </section>
            </main>";    

echo $productContainer;
require_once 'footer.php';
?>

