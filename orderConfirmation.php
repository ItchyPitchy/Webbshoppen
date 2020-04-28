<?php
require_once 'header.php';
require_once 'db.php'; 


$name = $_POST['name'];
$phone = $_POST['phone'];
$street = $_POST['street'];
$zipcode = $_POST['zipcode'];
$city = $_POST['city'];
$email = $_POST['email'];


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  $json = json_decode($_POST['cart']);

  $sql1 = "SELECT * FROM customers WHERE email = :email";
  $stmt1 = $db->prepare($sql1);
  $stmt1->bindParam(':email', $email);
  $stmt1->execute();

  if ($stmt1->rowCount() == 0) {
    $sql2 = "INSERT INTO `customers` (`name`, `email`, `phone`, `street`, `zipcode`, `city`) 
          VALUES (
                    '$_POST[name]',
                    '$_POST[email]', 
                    '$_POST[phone]', 
                    '$_POST[street]', 
                    '$_POST[zipcode]', 
                    '$_POST[city]'
                 )";
  
    $stmt2 = $db->prepare($sql2);
    $stmt2->execute();

  } else {

    $sql2 = "UPDATE `customers` 
             SET name = :name, phone = :phone, street = :street, zipcode = :zipcode, city = :city
             WHERE email = :email;
            ";

    $stmt2 = $db->prepare($sql2);
    $stmt2->bindParam(':name', $name);
    $stmt2->bindParam(':phone', $phone);
    $stmt2->bindParam(':street', $street);
    $stmt2->bindParam(':zipcode', $zipcode);
    $stmt2->bindParam(':city', $city);
    $stmt2->bindParam(':email', $email);
    $stmt2->execute();

  }
  // Lägger in kund id, summa, frakt i ordertabellen där kund id hämtas från kundtabellen med hjälp av email.
  $sql3 = "INSERT INTO active_orders (customers_id, sum, shipping) 
           VALUES ((SELECT customer_id from customers WHERE email = :email), :sum, :shipping)";

  $stmt3 = $db->prepare($sql3);
  $stmt3->bindParam(':email', $email);
  $stmt3->bindParam(':sum', $sum);
  $stmt3->bindParam(':shipping', $shipping);

  if ($json->sum > 500 || $_POST['city'] == 'stockholm'){

    $shipping = 0;

  } else{

    $shipping = 1;
  }

  $sum = $json->sum;

  $stmt3->execute(); 

  // Hämtar order id från aktiv order tabellen där senaste beställningen (beställningarna) från kunden som hämtas med hjälp av email
  $sql4 = "SELECT active_orders_id 
           FROM active_orders
           WHERE date = (SELECT MAX(date) FROM active_orders WHERE customers_id = (SELECT customer_id from customers WHERE email = :email))
           ORDER BY date desc;";

  $stmt4 = $db->prepare($sql4);
  $stmt4->bindParam(':email', $email);
  $stmt4->execute();

  $order_id = $stmt4->fetch(PDO::FETCH_ASSOC)["active_orders_id"];

  for ($i = 0; $i < count($json->products); $i++) {

  // Lägger in order id, product id och antal i active order products tabellen där id som ovan hämtats från active orders används, 
  // produkt id och antal som hämtas från json objektet/varukorgen
  $sql5 = "INSERT INTO active_orders_products (active_orders_id, products_id, quantity) 
           VALUES (:order_id, :product_id, :quantity)";

  $stmt5 = $db->prepare($sql5);
  $stmt5->bindParam(":order_id", $order_id);
  $stmt5->bindParam(":product_id", $product_id);
  $stmt5->bindParam(":quantity", $quantity);
  $product_id = $json->products[$i]->id;
  $quantity = $json->products[$i]->qty;
  $stmt5->execute();

  }

} 


?>
  

<main>
  <div class="orderConfirmation-section">
    <div class="heading-container">
        <h2 class="orderConfirmation-heading">Orderbekräftelse</h2>
        <p id="date"></p>
    </div>
    <div class="customerInfo-box">
    <p class="customer customer-order-id"></p>
    <p class="customer customer-name"></p>
    <p class="customer customer-email"></p>
    <p class="customer customer-phone"></p>
    <p class="customer customer-street"></p>
    </div>
    <div class="overview-container">
        <ul id="order-ul"></ul>
        <div class="overview-total">
            <p id="total-sum"></p>
            <p id="shipping-span"></p>
        </div>
    </div>
  </div>
      <div>
      <a class="back" href="index.php">Tillbaka till startsidan</a>
      </div>
  </main>



<script>
let orderId = "<?php echo $order_id ?>";
let name = "<?php echo $name ?>";
let email = "<?php echo $email ?>";
let phone = "<?php echo $phone ?>";
let street = "<?php echo $street ?>";
let zipcode = "<?php echo $zipcode ?>";
let city = "<?php echo $city ?>";
</script>

<script src="orderConfirmation.js"></script>


<?php
require_once 'footer.php';
?>