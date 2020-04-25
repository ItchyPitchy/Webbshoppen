<?php require_once "./header.php"; ?>

<main class="cart-section">
    <div class="heading-box">
        <h2 class="cart-heading">Kontrollera din order</h2>
    </div>
    <div class="cart-container">
        <ul id="cart"></ul>
        <div class="cart-total-box">
            <span id="total"></span>
            <span id="shipping">+ 50 kr frakt</span>
            <span class="shipping-info">fri frakt för beställning över 500 kr eller för leverans inom Stockholm</span>
        </div>
    </div>
    <form class="orderForm" id ="form" action="orderConfirmation.php" method="POST" onsubmit="return validateForm()">
        <h3 class="formTitle">Kontrollera din beställning och fyll i formuläret innan du avsutar ditt köp.</h3>
        <div>
            <label for="name">Namn*</label><br>
            <input id="name" name="name" required>    
        </div>
        <div>
            <label for="email">E-post*</label><br>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="phone">Telefon*</label><br>
            <input id="phone" name="phone"  required>
        </div>
        <div>
            <label for="street">Gatuadress*</label><br>
            <input id="street" name="street" required>
        </div>
        <div>
            <label for="zipcode">Postnummer*</label><br>
            <input id="zipcode" name="zipcode"  required>
        </div>
        <div>
            <label for="city">Ort*</label><br>
            <input id="city" name="city"  required>
        </div>
            <input id="submitBtn" class="orderConfirmBtn" type="submit" name="submit" value="Slutför köp">
            <input id="json" type="hidden" name="cart">
        
    </form>
</main>
<script src="order.js"></script>
<?php require_once "./footer.php";