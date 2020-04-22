const cart = document.querySelector("#cart");

if (localStorage.getItem("cartArr") !== null && JSON.parse(localStorage.getItem("cartArr")).products.length !== 0) {

    const cartArr = JSON.parse(localStorage.getItem("cartArr"));
    const products = cartArr.products;
    const total = document.querySelector("#total");
    total.textContent = `Totalsumma: ${cartArr.sum} kr`;

    for (let i = 0; i < cartArr.products.length; i++) {

        const li = document.createElement("li");

        const dltBtn = document.createElement("img");
        dltBtn.setAttribute("src", "./styles/images/delete.svg");
        dltBtn.setAttribute("data-id", products[i].id);
        dltBtn.classList.add("dlt-btn");
        li.appendChild(dltBtn);
        
        const productImage = document.createElement("img");
        productImage.setAttribute("src", products[i].image);
        productImage.classList.add("product-image");
        li.appendChild(productImage);

        const productTitle = document.createElement("span");
        productTitle.classList.add("product-title");
        productTitle.textContent = products[i].name;
        li.appendChild(productTitle);

        const qtyContainer = document.createElement("div");
        qtyContainer.classList.add("qty-container");

        const maxLimitAlert = document.createElement("span");
        maxLimitAlert.classList.add("max-limit-alert");
        maxLimitAlert.textContent = "Maxgränsen är nådd";
        qtyContainer.appendChild(maxLimitAlert);

        const decreaseBtn = document.createElement("button");
        decreaseBtn.setAttribute("data-id", products[i].id);
        decreaseBtn.classList.add("decrease-btn");
        if (products[i].qty <= 1) decreaseBtn.classList.add("hide");
        decreaseBtn.textContent = "-";
        qtyContainer.appendChild(decreaseBtn);

        const qtyInput = document.createElement("input");
        qtyInput.setAttribute("data-id", products[i].id);
        qtyInput.classList.add("qty-input");
        qtyInput.value = products[i].qty;
        qtyContainer.appendChild(qtyInput);

        const increaseBtn = document.createElement("button");
        increaseBtn.setAttribute("data-id", products[i].id);
        increaseBtn.classList.add("increase-btn");
        products[i].qty >= products[i].stock ? increaseBtn.classList.add("hide") : maxLimitAlert.classList.add("hide");
        increaseBtn.textContent = "+";
        qtyContainer.appendChild(increaseBtn);

        li.appendChild(qtyContainer);

        const price = document.createElement("span");
        price.classList.add("price");
        price.textContent = `${products[i].unitPrice * products[i].qty} kr`;
        li.appendChild(price);

        cart.appendChild(li);
    }

    const decreaseBtns = document.querySelectorAll(".decrease-btn");
    decreaseBtns.forEach(function(element) {

        element.addEventListener("click", function(e) {
            decreaseEvent(e.currentTarget);
        });
    });

    const increaseBtns = document.querySelectorAll(".increase-btn");
    increaseBtns.forEach(function(element) {

        element.addEventListener("click", function(e) {
            increaseEvent(e.currentTarget);
        });
    });

    const dltBtns = document.querySelectorAll(".dlt-btn");
    dltBtns.forEach(function(element) {

        element.addEventListener("click", function(e) {
            deleteEvent(e.currentTarget);
        });
    });

    const qtyInputs = document.querySelectorAll(".qty-input");
    qtyInputs.forEach(function(element) {

        element.addEventListener("input", function (e) {
            const cartArr = JSON.parse(localStorage.getItem("cartArr"));
            const inputValue = parseInt(e.currentTarget.value);
            let stock = 0;

            cartArr.products.forEach(function(element, index) {

                if (element.id === e.currentTarget.dataset.id) stock = element.stock;

            });

            if (isNaN(inputValue)) {
                e.currentTarget.value = "";
                e.currentTarget.parentElement.parentElement.querySelector(".increase-btn").classList.remove("hide");
                e.currentTarget.parentElement.parentElement.querySelector(".decrease-btn").classList.add("hide");
                e.currentTarget.parentElement.parentElement.querySelector(".max-limit-alert").classList.add("hide");
            } else if (inputValue >= stock) {
                e.currentTarget.value = stock;
                e.currentTarget.parentElement.parentElement.querySelector(".increase-btn").classList.add("hide");
                e.currentTarget.parentElement.parentElement.querySelector(".decrease-btn").classList.remove("hide");
                e.currentTarget.parentElement.parentElement.querySelector(".max-limit-alert").classList.remove("hide");
            } else if (inputValue <= 1) {
                inputValue < 1 ? e.currentTarget.value = "1" : e.currentTarget.value = inputValue;
                e.currentTarget.parentElement.parentElement.querySelector(".increase-btn").classList.remove("hide");
                e.currentTarget.parentElement.parentElement.querySelector(".decrease-btn").classList.add("hide");
                e.currentTarget.parentElement.parentElement.querySelector(".max-limit-alert").classList.add("hide");
            } else {
                e.currentTarget.value = inputValue;
                e.currentTarget.parentElement.parentElement.querySelector(".increase-btn").classList.remove("hide");
                e.currentTarget.parentElement.parentElement.querySelector(".decrease-btn").classList.remove("hide");
                e.currentTarget.parentElement.parentElement.querySelector(".max-limit-alert").classList.add("hide");
            }
            
            changePrice(e.currentTarget);
        });

        element.addEventListener("keypress", function(e) {

            if (e.which < 48 || e.which > 57) {
                e.preventDefault();
            }
        })

        element.addEventListener("blur", function(e) {

            const input = e.currentTarget.value.trim();

            if (input < 1) {
                e.currentTarget.value = "1";
                changePrice(e.currentTarget);
            }

        });
    });

    document.querySelector("#dropCartBtn").addEventListener("click", function(e) {
        dropCart();
    });
} else {
    total.textContent = "Totalsumma: 0 kr";
    cart.innerHTML = "<h2 class='empty'>Varukorgen är tom</h2><a href='./index.php'>Tillbaka till startsidan</a>";
    document.querySelector("#cashier").removeAttribute("href");
}



function dropCart() {
    total.textContent = "Totalsumma: 0 kr";
    document.querySelector("#cart").innerHTML = "<h2 class='empty'>Varukorgen är tom</h2><a href='./index.php'>Tillbaka till startsidan</a>";
    document.querySelector("#cashier").removeAttribute("href");
    localStorage.setItem("cartArr", JSON.stringify({products: [], sum: 0}));
}

function changePrice(input) {
    const inputValue = input.value.trim() === "" ? 0 : parseInt(input.value);
    const cartArr = JSON.parse(localStorage.getItem("cartArr"));

    cartArr.products.forEach(function(element, index) {

        if (element.id === input.dataset.id) {
            cartArr.sum = cartArr.sum - element.qty * element.unitPrice + inputValue * element.unitPrice;
            element.qty = inputValue;
            input.parentElement.parentElement.querySelector(".price").textContent = `${inputValue * element.unitPrice} kr`;
        }
    });

    total.textContent = `Totalsumma: ${cartArr.sum} kr`;
    localStorage.setItem("cartArr", JSON.stringify(cartArr));
}

function decreaseEvent(btn) {
    const cartArr = JSON.parse(localStorage.getItem("cartArr"));

    cartArr.products.forEach((element, index) => {

        if (element.id === btn.dataset.id) {
            element.qty = element.qty - 1;
            cartArr.sum = cartArr.sum - element.unitPrice;
            btn.nextElementSibling.value = element.qty;
            btn.parentElement.parentElement.querySelector(".price").textContent = `${element.qty * element.unitPrice} kr`;

            if (element.qty < element.stock) {
                btn.parentElement.querySelector(".increase-btn").classList.remove("hide");
                btn.parentElement.querySelector(".max-limit-alert").classList.add("hide");
            }

            if (element.qty <= 1) btn.classList.add("hide");
        }
    });

    total.textContent = `Totalsumma: ${cartArr.sum} kr`;
    localStorage.setItem("cartArr", JSON.stringify(cartArr));
}

function increaseEvent(btn) {
    const cartArr = JSON.parse(localStorage.getItem("cartArr"));

    cartArr.products.forEach((element, index) => {

        if (element.id === btn.dataset.id) {
            element.qty = element.qty + 1;
            cartArr.sum = cartArr.sum + element.unitPrice;
            btn.previousElementSibling.value = element.qty;
            btn.parentElement.parentElement.querySelector(".price").textContent = `${element.qty * element.unitPrice} kr`;

            if (element.qty > 1) btn.parentElement.querySelector(".decrease-btn").classList.remove("hide");

            if (element.qty >= element.stock) {
                btn.classList.add("hide");
                btn.parentElement.querySelector(".max-limit-alert").classList.remove("hide");
            }
        }
    });

    total.textContent = `Totalsumma: ${cartArr.sum} kr`;
    localStorage.setItem("cartArr", JSON.stringify(cartArr));
}

function deleteEvent(btn) {
    const cartArr = JSON.parse(localStorage.getItem("cartArr"));

    cartArr.products.forEach((element, index) => {

        if (element.id === btn.dataset.id) {
            cartArr.sum = cartArr.sum - element.qty * element.unitPrice;
            cartArr.products.splice(index, 1);
        }
    });

    const listItem = btn.parentElement;

    listItem.parentElement.removeChild(listItem);
    total.textContent = `Totalsumma: ${cartArr.sum} kr`;
    localStorage.setItem("cartArr", JSON.stringify(cartArr));

    if (cartArr.products.length === 0) {
        total.textContent = "Totalsumma: 0 kr";
        cart.innerHTML = "<h2 class='empty'>Varukorgen är tom</h2><a href='./index.php'>Tillbaka till startsidan</a>";
        document.querySelector("#cashier").removeAttribute("href");
    }
}