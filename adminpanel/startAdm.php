<?php
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
    
      <form id="categoryForm" action="newCategory.php" method="POST" class="catForm" onsubmit="return validateForm()">
      
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



