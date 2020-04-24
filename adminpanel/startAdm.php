<?php
require_once '../db.php';
require_once 'header.php';

?>

<div class="main-container">
    
      <form action="process.php" method="POST" class="catForm">
        <label for="category" class="textLabel">Skapa en ny kategori</label>
        <input type="text" name="category" placeholder="Kategori" class="catInput">
        <button type="submit" name="save" class="catSaveBtn">Spara</button>
      </form>


<div class="categoryContainer">
  <table class="catTable">
    <thead>
      <tr>
        <th class="categoryHead">Kategorier</th>
      </tr>
    </thead>
    


<?php 
$sql = "SELECT * FROM category";
$stmt = $db->prepare($sql);
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  $category = htmlspecialchars($row['category']);
  $category_id = htmlspecialchars($row['category_id']);
  
$output ="<tr>

            <td>
              <a class='categoryName' href='productAdm.php?category_id=$category_id'>$category</a>
            </td>

            <td>
              <a class='updateBtn' href='productAdm.php?category_id=$category_id'>Redigera </a>
            </td>

            <td>
              <a href='#' class='deleteBtn' >  Radera </a>
          </td>
          </tr>";

  echo $output;
}
?>
</table>
</div>
</div>

<?php
require_once 'footer.php';
?>

