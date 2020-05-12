<?php require_once "./header.php"; ?>

<main class="cart-section">
    <div class="heading-box">
   <img src="./styles/images/cart.svg" alt="" class="cart-img"> 
   <h2 class="cart-heading">Din varukorg</h2>
   </div>
    <div class="cart-container">
        <ul id="cart" class="grid"></ul>
        <div class="cart-total-box">
            <span id="total"></span>
            <span id="disSum"></span>
            <a href="./order.php" id="cashier">Till kassan</a>
        </div>
        <div id="dropCartBtn">Töm varukorgen</div>
    </div>
</main>
<script src="cart.js"></script>

<?php require_once "./footer.php"; ?>