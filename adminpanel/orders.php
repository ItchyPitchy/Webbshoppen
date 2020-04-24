
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

  if (sizeof($product_list)==0){
    break;
  }
  
  if ($status == 0) {
    $statusform = "<form action='#' method='POST'>
    <select class='orderstatus-select' name='status'>
    <option name='option' selected='selected' value='0'>Ny</option>
    <option name='option' value='1'>Behandlas</option>
    </select>
    <input type='submit' value='Ändra status'></form>";
  }
  else {
    $statusform =  "<form action='#' method='POST'>
    <select class='orderstatus-select' name='status'>
    <option name='option' value='0'>Ny</option>
    <option name='option' selected='selected' value='1'>Behandlas</option>
    </select>
    <input type='submit' value='Ändra status'></form>";
  }
  
  $products = implode($product_list);
    $orderContainer  .=  "<ul class='order-tr'>
      <div class='column-div'><li class='order-td'>$name</li>
      <li class='order-td'>$phone</td>
      <li class='order-td'>$street, $city </li></div>
      <div class='column-div'><li class='order-td'>$date</li>
      <li class='order-td'>$products</li>
      <li class='order-td'>$sum:-</li></div>
      <div class='column-div'><li class='order-td'>$statusform</li>
      </ul>"; 
}



$mysqli = new mysqli("localhost","root","","webshop");
if ($result = $mysqli->query("SELECT * FROM active_orders LIMIT 1"))
{
    if ($obj = $result->fetch_object())
    {}
    else
    {
    $orderContainer .= "<br><br><Span>Det finns inga aktiva beställningar</span>";
  }
    $result->close();
}
$mysqli->close();

$orderContainer .= "</div></div>";
echo $orderContainer;     

require_once "footer.php";
?>

