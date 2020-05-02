<?php

require_once '../db.php';

if(isset($_GET['id'])){
  
  $id = htmlspecialchars($_GET['id']); 

  $sql = "UPDATE products SET deleted = 1 WHERE id = :id";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();

}

header("Location:$_SERVER[HTTP_REFERER]");

?>
