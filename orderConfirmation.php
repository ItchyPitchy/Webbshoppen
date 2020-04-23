<?php
require_once 'header.php';
require_once 'db.php'; 


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  $json = json_decode($_POST['cart']);

  $sql1 = "SELECT * FROM customers WHERE email = :email";
  $stmt1 = $db->prepare($sql1);
  $stmt1->bindParam(':email', $email);
  $email = $_POST['email'];
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
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $street = $_POST['street'];
    $zipcode = $_POST['zipcode'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    $stmt2->execute();

  }

  $sql3 = "INSERT INTO active_orders (customers_id, sum, shipping) 
           VALUES ((SELECT customer_id from customers WHERE email = :email), :sum, :shipping)";

  $stmt3 = $db->prepare($sql3);
  $stmt3->bindParam(':email', $email);
  $stmt3->bindParam(':sum', $sum);
  $stmt3->bindParam(':shipping', $shipping);

  if ($json->sum > 500 || $_POST['city'] == 'stockholm'){

    $shipping = 1;

  } else{

    $shipping = 0;
  }

  $sum = $json->sum;

  $email = $_POST['email'];

  $stmt3->execute(); 

  $sql4 = "SELECT active_orders_id 
          FROM
            active_orders
          WHERE
          (SELECT customer_id from customers WHERE email = :email) AND MAX(date)";

  $stmt4 = $db->prepare($sql4);
  $stmt4->bindParam(':email', $email);
  $stmt4->execute();


  print_r ($stmt4);

  // Hämtar input från order-formuläret
  $name    = htmlentities(($_POST['name']));
  $email   = htmlentities(($_POST['email']));
  $phone   = htmlentities(($_POST['phone']));
  $street  = htmlentities(($_POST['street']));
  $zipcode = htmlentities(($_POST['zipcode']));
  $city    = htmlentities(($_POST['city']));

  echo $name     . "<br>";
  echo $email    . "<br>";
  echo $phone    . "<br>";
  echo $street   . "<br>";
  echo $zipcode  . "<br>";
  echo $city     . "<br>";


  // echo "Insert complete!";
} 


?>


























<main class="cart-section">
    <div class="heading-box">
        <h2 class="cart-heading">Orderbekräftelse</h2>
    </div>
    <div class="cart-container">
        <ul id="cart"></ul>
        <div class="cart-total-box">
            <span id="total"></span>
            <span id="shipping">+ 50 kr frakt</span>
            <span class="shipping-info">fri frakt för beställning över 500 kr eller för leverans inom Stockholm</span>
        </div>
    </div>
</main>
<script type = "text/javascript" src="orderConfirmation.js"></script>


<?php
require_once 'footer.php';
?>