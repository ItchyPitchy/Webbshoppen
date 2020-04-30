const headerCart = document.querySelector("#header-cart");

if (localStorage.getItem("cartArr") !== null && JSON.parse(localStorage.getItem("cartArr")).products.length !== 0) {
    headerCart.style = "fill: red;";
}