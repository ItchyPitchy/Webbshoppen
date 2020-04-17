<?php require_once "./header.php"; ?>

<main>
    <h2>Din varukorg</h2>
    <div class="cart-container">
        <ul id="cart" class="grid"></ul>
        <div>
            <span id="total"></span>
            <a href="#">Till kassan</a>
            <button id="dropCartBtn">Töm varukorgen</button>
        </div>
    </div>
</main>
<script src="cart.js"></script>

<?php require_once "./footer.php"; ?>