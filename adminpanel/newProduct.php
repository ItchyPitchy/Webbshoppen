<?php

require_once "db.php";
require_once 'header.php';

$ids = isset($_GET['category_id']) ? $_GET['category_id'] : header('Location:index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') :
  
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $stock = htmlspecialchars($_POST['stock']);
    $price = htmlspecialchars($_POST['price']); 
    $category_id = htmlspecialchars($_GET['category_id']);

    $stmt = $db->prepare("INSERT INTO products (name,description,stock,price,category_id) 
                            VALUES (:name, :description, :stock , :price,:category_id) ");

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':category_id', $category_id);
    
    $stmt->execute();

    $last_id = $db->lastInsertId();
    //echo "New record created successfully. Last inserted ID is: " . $last_id . "<br>" ; 
    
    // File upload configuration 
    $targetDir = "../images/"; 
    $allowTypes = array('jpg','png','jpeg','gif');
    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
    $fileNames = array_filter($_FILES['files']['name']); 
    
    
    if(!empty($fileNames)){ 

        foreach($_FILES['files']['name'] as $key=>$val){ 
            // File upload path 
            $fileName = basename($_FILES['files']['name'][$key]); 
            $targetFilePath = $targetDir . $fileName; 
            
            // Check whether file type is valid 
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
            if(in_array($fileType, $allowTypes)){ 
                // Upload file to server 
                if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){ 
                    // Image db insert sql 
                    $insertValuesSQL .= "('".$fileName."','".$last_id."'),"; 

                }else{ 
                    $errorUpload .= $_FILES['files']['name'][$key].' | '; 
                } 
            }else{ 
                $errorUploadType .= $_FILES['files']['name'][$key].' | '; 
            } 
        } 


        if(!empty($insertValuesSQL)){ 
            $insertValuesSQL = trim($insertValuesSQL, ','); 
            // Insert image file name into database 

            $sql= "INSERT INTO product_images (image, product_id) VALUES $insertValuesSQL";
            //echo $sql;
            $insert = $db->prepare($sql);
            $insert->execute();

            if($insert){ 
                $errorUpload = !empty($errorUpload)?'Upload Error: '.trim($errorUpload, ' | '):''; 
                $errorUploadType = !empty($errorUploadType)?'File Type Error: '.trim($errorUploadType, ' | '):''; 
                $errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType; 
                $statusMsg = "Bilderna är uppladdade.".$errorMsg; 
            }else{ 
                $statusMsg = "Sorry, Något gick snet."; 
            } 
        } 
    }else{ 
        $statusMsg = 'Välj en bild för att ladda upp.'; 
    } 
    
    // Display status message 
    echo $statusMsg; 
    
    //echo '<script type="text/javascript">';
    //echo ' alert("JavaScript Alert Box by PHP")';  //not showing an alert box.
    //echo '</script>';
    header('Location:#popup1');
    //function_alert();
endif;
    
    
    
    
    
function function_alert() {
    echo "<script type='text/javascript'>
    location.href = '#popup1';
    </script>";
}
?>
<div>
<form action="#" method="POST" class="productForm" enctype="multipart/form-data">
<div>
<label class="formTitle22">Skapa produkt</label>
</div>
<div class="">
        <label class="labelss" for="name">Produkts namn:</label>
        <input name="name" type="text" maxlength="100" autofocus required class="productGroupForm" >
    </div>
    <div>
        <label class="labelss" for="description">Beskrivning:</label>
        <textarea name="description" rows="3" maxlength="600" class="productGroupForm" ></textarea>
    </div>
    <div>
        <label class="labelss" for="stock">Antal i lager:</label>
        <input id="stock" type="number" name="stock" min="0"  class="productGroupForm" placeholder="">
    </div>
    <div>
        <label class="labelss" for="price">pris:</label>
        <input name="price" type="number" min="0" class="productGroupForm">
    </div>
    <div>
        <label class="labelss" for="image">Ladda upp bilder på produkten! (MAX 5)</label>
        <input type='file' id="file" onchange="loadFile(event)" class="productGroupForm" name='files[]' multiple/>
        <ul id="imgUl"></ul>
    </div>
    <div>
        <input type="submit" value="Skapa" class="productConfirmBtnn"> 
    </div>
</form>
</div>

<script type="text/javascript">

var loadFile = function (event) {   

    const imgUl = document.querySelector("#imgUl");
    
    for(i = 0; i < event.target.files.length; i++) {
        
        const li = document.createElement("li");
        
        let image = document.createElement("img")
        image.classList.add("selected-img");
        image.src = URL.createObjectURL(event.target.files[i]);
        li.appendChild(image);
        imgUl.appendChild(li);

    }
};

</script>



<?php /*
<div class="box">
    <a class="button" href="#popup1">Let me Pop up</a>
</div>*/
?>
<div id="popup1" class="overlay">
    <div class="popup">
        <h2>Produkten är tillagd.</h2>
        <a class="close" href="index.php">OK</a>
        <div class="content">
       
        </div>
    </div>
</div>

<?php require_once "./footer.php"; 



