<?php

require_once "./header.php";
require_once '../db.php';


?>


<!-- Test ner-->
<script type = "text/javascript">

function validateForm(){

	const category = document.getElementById('category');
	const popMessage = document.getElementById('popMessage');

	

	if(category.value.trim() == null || category.value.trim() == ''){

		popMessage.innerText = 'Ange en title till kategorin.'
		setTimeout(function(){
			popMessage.innerText = ''
		}, 3000);
		return false;
	}
	if(category.value.match(/\d+/g)){
		
		popMessage.innerText = 'Title på kategorin får inte innehålla siffror.'
		setTimeout(function(){
			popMessage.innerText = ''
		}, 3000);
		return false;
	}
	if(category.value.length < 2){
		
		popMessage.innerText = 'Title på kategorin måste innehålla minst vara 2 tecken.'
		setTimeout(function(){
			popMessage.innerText = ''
		}, 3000);
		return false;
	}
	if(category.value.length > 20){
		
		popMessage.innerText = 'Title får vara max 20 tecken.'
		setTimeout(function(){
			popMessage.innerText = ''
		}, 3000);
		return false;
	}


  
	return true;

}

</script>

<!-- Test up -->

<div class="main-container">
    
      <form id="categoryForm" action="newCategory.php#newCategoryMessage" method="POST" class="catForm" accept-charset="utf8mb4_unicode_ci" onsubmit="return validateForm()">
      
        <label for="category" class="textLabel">Skapa en ny kategori</label>
        <input type="text" name="category" id="category" placeholder="Kategori" class="catInput">
        <button type="submit" name="save" class="catSaveBtn" value="Save">Spara</button>
      </form>
      <div id="popMessage"></div>


<div class="categoryContainer">
  <table class="catTable">
    <thead>
      <tr>
        <th class="categoryHead">Kategorier</th>
      </tr>
    </thead>
    


<?php

$dlt_error = "";

if (isset($_GET["delete"])) {
  
  $sql2 = "SELECT * FROM products WHERE category_id = :dlt_id";
  $stmt2 = $db->prepare($sql2);
  $stmt2->bindParam(":dlt_id", $dlt_id);
  $dlt_id = $_GET["delete"];
  $stmt2->execute();

  if ($stmt2->rowCount() === 0) {
    $sql3 = "DELETE FROM category WHERE category_id = :dlt_id";
    $stmt3 = $db->prepare($sql3);
    $stmt3->bindParam(":dlt_id", $dlt_id);
    $stmt3->execute();
  } else {
    $dlt_error = "Fel: kategorin innehåller produkter";
  }
} else if (isset($_POST["category"]) && isset($_POST["update_id"])) {
  $sql4 = "UPDATE category SET category = :category WHERE category_id = :update_id";
  $stmt4 = $db->prepare($sql4);
  $stmt4->bindParam(":category", $category);
  $stmt4->bindParam(":update_id", $category_id);
  $category = htmlspecialchars($_POST["category"]);
  $category_id = htmlspecialchars($_POST["update_id"]);
  $stmt4->execute();
}

$sql = "SELECT * FROM category";
$stmt = $db->prepare($sql);
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  $category = htmlspecialchars($row['category']);
  $category_id = htmlspecialchars($row['category_id']);
  
  $output ="<tr>";

  if (isset($_GET["update"]) && $category_id === $_GET["update"]) {

    $output .= "<td>
                  <form action='./index.php' method='POST' onsubmit='return validateForm()'>
                    <input id='category-input' name='category' value='" . htmlspecialchars_decode($category) . "'>
                    <input class='hide' type='submit' name='submit' value='submit'>
                    <input type='hidden' name='update_id' value='$_GET[update]'>
                    <div id='input-length-counter'></div>
                  </form>
                </td>
                <td></td>";

  } else {

    $output .= "<td>
                  <a class='categoryName' href='./productAdm.php?category_id=$category_id'>" . htmlspecialchars_decode($category) . "</a>
                </td>
                <td>
                  <a class='updateBtn' href='./index.php?update=$category_id'>Redigera</a>
                </td>";
  }

            

              $output .= "<td>
                            <a href='./index.php?delete=$category_id' class='deleteBtn' >  Radera </a>";

  if (strlen($dlt_error) && $category_id === $_GET["delete"]) {

    $output .= "<span class='dlt-error'>$dlt_error</span>";
    
  }

  $output .= "</td>
            </tr>";

  echo $output;
}
?>
</table>
</div>
</div>
</div>
<script src="startAdm.js"></script>

<?php require_once "./footer.php"; ?>