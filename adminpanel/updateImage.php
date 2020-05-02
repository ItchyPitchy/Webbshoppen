<?php

require_once 'db.php';
require_once 'header.php';

$id = isset($_POST['id']) ? $_POST['id'] : header('Location:index.php');

$targetDir = "../images/"; 
$allowTypes = array('jpg','png','jpeg','gif');
$statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
$fileNames = array_filter($_FILES['files']['name']); 
$productId = htmlspecialchars($_POST['id']);

$sql4 = "SELECT category_id FROM products WHERE id = :id";
$stmt4 = $db->prepare($sql4);
$stmt4->bindParam(':id', $productId);
$stmt4->execute();

$row4 = $stmt4->fetch(PDO::FETCH_ASSOC);  
$category = htmlspecialchars($row4['category_id']);


//echo $productId;
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
                    $insertValuesSQL .= "('".$fileName."','".$productId."'),"; 
                }else{ 
                    $errorUpload .= $_FILES['files']['name'][$key].' | '; 
                } 
            }else{ 
                $errorUploadType .= $_FILES['files']['name'][$key].' | '; 
            } 
        } 
        
        if(!empty($insertValuesSQL)){ 
            $insertValuesSQL = trim($insertValuesSQL, ','); 
            
            // Delete image files name into database 
            $sql = "DELETE FROM product_images WHERE product_id= :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $productId);
            $stmt->execute();
                      
              // echo '<script type="text/javascript">';
              //  echo ' alert("test")';  //
              //  echo '</script>';

            // Insert image file name into database 
            $sql2 = "INSERT INTO product_images (image, product_id) VALUES $insertValuesSQL";
           // echo $sql2;
            $insert = $db->prepare($sql2);
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
    //header('Location:#popup1');
    // header('Location:index.php');
    //function_alert();
    //header('Location:#popup1');
    echo "<script type='text/javascript'>location.href ='#popup1' ; </script>";
    ?>

    <div id="popup1" class="overlay">
        <div class="popup">
            <h2>Bilderna är uppdaterade.</h2>
            <a class="close" href="productAdm.php?category_id=<?php echo $category; ?>">OK</a>
            <div class="content">
           
            </div>
        </div>
    </div>

    <?php require_once "./footer.php";  ?>