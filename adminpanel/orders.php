
<?php

require_once "../db.php";
require_once "header.php";
?>

<div class="main-container">
      <h2 class="admin_h2">Beställningar</h2>
      <p class="filtrera-p">Filtrera beställningar</p>
          <form class="search-form" action="" method="post">
        <input class="search-input" type="text" />
        <button class="search-submit-btn" type="submit">Sök</button>
    </form>

  
    <div class="radio-div">
    <input type="radio" id="alla" name="alla" checked="checked">
    <label for="alla">Alla beställningar</label>
    <input type="radio" id="aktiva" name="alla">
    <label for="aktiva">Aktiva beställningar</label>
    <input type="radio" id="slutförda" name="alla">
    <label for="slutförda">Slutförda beställningar</label>
    </div>

  <div class="selectbox-div">
  <select id="sort">
  <option value="senaste">Senaste beställningarna</option>
  <option value="tidgaste">Äldsta beställningarna</option>
  <option value="dyraste">Dyraste beställningarna</option>
  <option value="billigaste">Billigaste beställningarna</option>
  <option value="Obehandlade">Obehandlade beställningar</option>
  <option value="behandlas">Behandlade beställningarna</option>
</select>
  </div>

<?php

/***********************************************************Active orders table**************************************************************** */

$orderContainer = '<div class="orderContainer">';

echo "<h2 class='startpageHeading'>Aktiva Beställningar</h2>";


    $orderContainer  .=  "<ul class='order-tr'>
      <div class='column-div'><h3>Kund<h3></div>
      <div class='column-div'><h3>Beställning<h3></div>
      <div class='column-div'><h3>Status<h3></div>
      </ul>"; 
 

$sql = "SELECT * FROM active_orders";
$stmt = $db->prepare($sql);
$stmt->execute();



while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

  $products_id_list = [];
  $quantity_list = []; 
  $product_list = [];
  $errors = 0;

  $active_orders_id = $row['active_orders_id'];

  $sum = $row['sum'];
  $status = $row['status'];
  $shipping = $row['shipping'];
  $date = $row['date'];
  $customers_id = $row['customers_id'];


  $sql = "SELECT * FROM customers";
  $stmt2 = $db->prepare($sql);
  $stmt2->execute();

  while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){

    if ($customers_id == $row2['customer_id']) {
      $name = $row2['name'];
      $phone = $row2['phone'];
      $street = $row2['street'];
      $city = $row2['city'];

      $sql = "SELECT * FROM active_orders_products";
      $stmt3 = $db->prepare($sql);
      $stmt3->execute();

      while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
        if ($active_orders_id == $row3['active_orders_id']) {
                    
          array_push($products_id_list, $row3['products_id']);
          array_push($quantity_list, $row3['quantity']);
                    
          $sql = "SELECT * FROM products";
          $stmt4 = $db->prepare($sql);
          $stmt4->execute();

          while($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)){
            if ($row3['products_id'] == $row4['id']) {
              array_push($product_list, $row4['name'], " : ", $row3['quantity'],"  st, <br>");

            }        
          } 
        }
      }
    }
  }

  
  if ($status == 0) {
    $statusform = "<form action='orders.php?id=$active_orders_id' method='POST'>
    <select class='orderstatus-select' name='status'>
    <option name='option' selected='selected' value='0'>Ny</option>
    <option name='option' value='1'>Behandlas</option>
    <option name='option' value='completed'>Slutförd</option>

    </select>
    <input type='submit' value='Ändra status' class='statusBtn'></form>";
  }
  else {
    $statusform =  "<form action='orders.php?id=$active_orders_id' method='POST'>
    <select class='orderstatus-select' name='status'>
    <option name='option' value='0'>Ny</option>
    <option name='option' selected='selected' value='1'>Behandlas</option>
    <option name='option' value='completed'>Slutförd</option>

    </select>
    <input type='submit' value='Ändra status' class='statusBtn'></form>";
  }
  
  $products = implode($product_list);
    $orderContainer  .=  "<ul class='order-tr'>
      <div class='column-div'><li class='order-td'>$name</li>
      <li class='order-td'>$phone</td>
      <li class='order-td'>$street, $city </li></div>
      <div class='column-div'>
      <li class='order-td'>Ordernummer: $active_ordersq_id</li>
      <li class='order-td'>$date</li>
      <li class='order-td'>$products</li>
      <li class='order-td'>$sum:-</li></div>
      <div class='column-div'><li class='order-td'>$statusform</li>
      </ul>"; 
}


function ifEmpty ($str, $table, &$container) {
  $mysqli = new mysqli("localhost","root","","webshop");
  if ($result = $mysqli->query("SELECT * FROM $table LIMIT 1")){
    if ($obj = $result->fetch_object())
    {}
    else
    {
    $container .= "<br><br><Span>$str</span>";
  }
    $result->close();
}
$mysqli->close();
}

ifEmpty("Det finns inga aktiva beställningar", "active_orders", $orderContainer);

$orderContainer .= "</div>";
echo $orderContainer;    


/***********************************************************Completed orders table**************************************************************** */


$completedOrderContainer = '<div class="orderContainer secondContainer">';

echo "<h2 class='startpageHeading secondHeadingOrders'>Slutförda Beställningar</h2>";


    $completedOrderContainer  .=  "<ul class='order-tr'>
      <div class='column-div'><h3>Kund<h3></div>
      <div class='column-div'><h3>Beställning<h3></div>
      </ul>"; 
 

$sql = "SELECT * FROM completed_orders";
$stmt = $db->prepare($sql);
$stmt->execute();


while($row = $stmt->fetch(PDO::FETCH_ASSOC)){



  $products_id_list = [];
  $quantity_list = []; 
  $product_list = [];

  $completed_orders_id = $row['completed_orders_id'];

  $sum = $row['sum'];
  $date = $row['date'];
  $customers_id = $row['customers_id'];


  $sql = "SELECT * FROM customers";
  $stmt2 = $db->prepare($sql);
  $stmt2->execute();

  while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){

    if ($customers_id == $row2['customer_id']) {
      $name = $row2['name'];
      $phone = $row2['phone'];
      $street = $row2['street'];
      $city = $row2['city'];

      $sql = "SELECT * FROM completed_orders_products";
      $stmt3 = $db->prepare($sql);
      $stmt3->execute();

      while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){

        if ($completed_orders_id == $row3['completed_orders_id']) {
          array_push($products_id_list, $row3['products_id']);
          array_push($quantity_list, $row3['quantity']);
                    
          $sql = "SELECT * FROM products";
          $stmt4 = $db->prepare($sql);
          $stmt4->execute();

          while($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)){
            if ($row3['products_id'] == $row4['id']) {
              array_push($product_list, $row4['name'], " : ", $row3['quantity'],"  st, <br>");

            }        
          } 
        }
      }
    }
  }

  
  $products = implode($product_list);
    $completedOrderContainer  .=  "<ul class='order-tr'>
      <div class='column-div'><li class='order-td'>$name</li>
      <li class='order-td'>$phone</td>
      <li class='order-td'>$street, $city </li></div>
      <div class='column-div'>
      <li class='order-td'>Ordernummer: $completed_orders_id</li>
      <li class='order-td'>$date</li>
      <li class='order-td'>$products</li>
      <li class='order-td'>$sum:-</li></div>
      </ul>"; 
}



ifEmpty("Det finns inga slutförda beställningar", "completed_orders", $completedOrderContainer);


$completedOrderContainer .= "</div></div>";
echo $completedOrderContainer;  

/*********************************************************Change status code******************************************************* */
if(isset($_GET['id'])){
  $active_orders_id = $_GET['id'];
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

  if ($_POST['status'] === "completed") {

    $sql = "SELECT * FROM active_orders";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

      if ($row['active_orders_id'] == $active_orders_id) {
              echo $active_orders_id;

          $sql2 = "INSERT INTO completed_orders (completed_orders_id, customers_id, sum, shipping, date)
          VALUES ( :completed_orders_id , :customers_id , :sum , :shipping , :date ) ";

          $stmt2 = $db->prepare($sql2);

          $completed_orders_id = $active_orders_id;

          echo $completed_orders_id . $row['customers_id'] . $row['sum'] . $row['shipping'] . $row['date'];
        
 
  
        $stmt2->bindParam(':completed_orders_id' , $completed_orders_id );
        $stmt2->bindParam(':customers_id'  , $row['customers_id']);
        $stmt2->bindParam(':sum'  , $row['sum']);
        $stmt2->bindParam(':shipping'  , $row['shipping']);
        $stmt2->bindParam(':date'  , $row['date']);
        
        $stmt2->execute();

      }
    }
   
    $sql = "SELECT * FROM active_orders_products";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

      if ($row['active_orders_id'] == $active_orders_id) {
              echo $active_orders_id;

          $sql2 = "INSERT INTO completed_orders_products (completed_orders_id, products_id, quantity)
          VALUES ( :completed_orders_id , :products_id , :quantity ) ";

          $stmt2 = $db->prepare($sql2);

          $completed_orders_id = $active_orders_id;
  
        $stmt2->bindParam(':completed_orders_id' , $completed_orders_id );
        $stmt2->bindParam(':products_id'  , $row['products_id']);
        $stmt2->bindParam(':quantity'  , $row['quantity']);

        
        $stmt2->execute();

      }
    }

    $sql = "DELETE FROM active_orders_products
            WHERE active_orders_id = :active_orders_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':active_orders_id', $active_orders_id);
    $stmt->execute();

    $sql = "DELETE FROM active_orders WHERE active_orders_id = :active_orders_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':active_orders_id', $active_orders_id);
    $stmt->execute();
  }

  else {
  echo $_POST['status'];
  echo "in if";

  $status = htmlentities($_POST['status']);

  $sql = "UPDATE active_orders
          SET status = :status
          WHERE active_orders_id = :active_orders_id";

  $stmt = $db->prepare($sql);

  $stmt->bindParam(':status', $status);
    $stmt->bindParam(':active_orders_id', $active_orders_id);

   $stmt->execute();
  }
  echo "<script type='text/javascript'>location.href = 'orders.php'    ; </script>";
  exit;

}


require_once "footer.php";
?>



