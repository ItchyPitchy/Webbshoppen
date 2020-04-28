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

 $output = '';
 
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
                                <a class='admUpdateBtn' href='updateProduct.php?id=$id' >Redigera </a>
                            </td>
    
                            <td class='admDeleteTd'>
                                <button name='modalDeleteBtn' id='button$id' class='admDeleteBtn'> Radera </button>
                            </td>                          

                            <div class='modal-bg' id='button$id'>
                                <div class='modal'>
                                    <h2 class='modalWarning'>Vill du ta bort produkt?</h2>
                                    <div>
                                        <button name='closeModal' class='cancelModal' id= '$id'>Avbryt</button>
                                        <a class='modalDeleteBtn' href='deleteProduct.php?id=$id'> Ta bort </a>
                                        <span name='closeModal' class='modal-close'>X</span>
                                    </div>
                                </div>
                            </div>                    
                         </tr>";
            $x++;
            break;
            }
        }

         echo $output;
}

?>
</table>
</div>
</div>

<script>
    const modalDeleteBtn= document.getElementsByName("modalDeleteBtn");
    const closeModal= document.getElementsByName("closeModal");

    for(let i=0;i<modalDeleteBtn.length;i++){
        modalDeleteBtn[i].onclick = function(e){
        const modalBg = document.querySelector(`#${e.currentTarget.id}`);
        modalBg.classList.add('bg-active');
        console.log(e.target);
     }
    }

    for(let i=0;i<closeModal.length;i++){
    closeModal[i].onclick = function(e){
        const modalBg = e.currentTarget.parentElement.parentElement.parentElement;
        modalBg.classList.remove('bg-active');
        }
    }
</script>

<?php
require_once 'footer.php';
?>



