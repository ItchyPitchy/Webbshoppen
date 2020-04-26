<?php
require_once '../db.php';
require_once 'header.php';

?>

<div class=" main-container adm-container">
    <form action="#" method="POST" class="catForm">
        <label for="category" class="textLabel">Redigera</label>
        <input type="text" name="category" placeholder="Kategori" class="catInput">
        <button type="submit" name="save" class="catSaveBtn">Spara</button>
    </form>

<?php
$x = 0;
if(isset($_GET['category_id'])){
    
    $category_id = htmlspecialchars($_GET['category_id']);

    $sql = "SELECT * FROM products WHERE category_id = :category_id";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->execute(); 

}
$link = "<a class='linkToNewProduct' href='newProduct.php?category_id=$category_id'>+</a>";

$head = "<div class='productContainer'>
            <table class='productTable'>
                <thead>
                    <tr>
                        <th class='productHead'>Produkter $link </th>
                    </tr>
                </thead>";

 echo $head;
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
   
        $sql ="SELECT * FROM product_images";
        $stmt2 =$db->prepare($sql);
        $stmt2 ->execute();

        while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
            if($row['id'] == $row2['product_id']){
                $name = htmlspecialchars($row['name']);
                $id = $row['id'];
                $img = "../images/" . $row2['image'];

                $output ="<tr class='productContainer'>
                            <td class='imgAdm'><img src=$img></td>
    
                            <td class='admProductName'> $name </td>
    
                            <td class='admUpdateTd'>
                                <a class='admUpdateBtn' href='#' >Redigera </a>
                            </td>
    
                            <td class='admDeleteTd'>
                                <a class='admDeleteBtn' href='#' >  Radera </a>
                            </td>
                
            </tr>";
            $x++;
            break;
            }
        
        }
        // echo '
        // <div></div>
        // ';
        
        
         echo $output;
}

?>
</table>
</div>
</div>


<?php
require_once 'footer.php';
?>



