<?php require_once "./header.php"; ?>

<main class="cart-section">
    <div class="heading-box">
        <h2 class="cart-heading">Leverans</h2>
    </div>
    <div class="cart-container">
        <ul id="cart"></ul>
        <div class="cart-total-box">
            <span id="total"></span>
            <span id="shipping">+ 50 kr frakt</span>
            <span class="shipping-info">fri frakt för beställning över 500 kr eller för leverans inom Stockholm</span>
        </div>
    </div>
    <form id ="form" action="orderConfirmation.php" method="POST" onsubmit="return validateForm()">
        <label for="name">Namn*</label>
        <input id="name" name="name" placeholder="Ange för- och efternamn" required><br>
        <label for="email">E-post*</label>
        <input type="email" id="email" name="email" placeholder="Ange e-postadress" required><br>
        <label for="phone">Telefon*</label>
        <input id="phone" name="phone" placeholder="Ange telefon-nummer" required><br>
        <label for="street">Gatuadress*</label>
        <input id="street" name="street" placeholder="Ange gatuadress" required><br>
        <label for="zip-code">Postnummer*</label>
        <input id="zip-code" name="zip-code" placeholder="Ange postnummer" required><br>
        <label for="city">Ort*</label>
        <input id="city" name="city" placeholder="Ange ort" required><br>
        <input id="submitBtn" type="submit" name="submit" value="Slutför köp">
        <input id="json" type="hidden" name="cart">
    </form>
</main>
<script src="order.js"></script>
<?php require_once "./footer.php";