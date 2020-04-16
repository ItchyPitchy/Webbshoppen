fetch("http://localhost/Webbshoppen/api.php")
    .then(response => response.json())
    .then(json => {
        
        console.log(json);
        
        const cartArr = JSON.parse(localStorage.getItem("cartArr"));
        const products = cartArr.products;

        const cart = document.querySelector("#cart");
        // let content = "";

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

            const decreaseBtn = document.createElement("div");
            decreaseBtn.setAttribute("data-id", products[i].id);
            decreaseBtn.classList.add("decrease-btn");
            if (products[i].qty <= 1) decreaseBtn.classList.add("hide");
            // decreaseBtn.textContent = "-";
            qtyContainer.appendChild(decreaseBtn);

            const qtyInput = document.createElement("input");
            qtyInput.setAttribute("data-id", products[i].id);
            qtyInput.classList.add("qty-input");
            qtyInput.value = products[i].qty;
            qtyContainer.appendChild(qtyInput);

            const increaseBtn = document.createElement("div");
            increaseBtn.setAttribute("data-id", products[i].id);
            increaseBtn.classList.add("increase-btn");
            if (products[i].qty >= 100) increaseBtn.classList.add("hide");
            // increaseBtn.textContent = "+";
            qtyContainer.appendChild(increaseBtn);

            li.appendChild(qtyContainer);

            const price = document.createElement("span");
            price.classList.add("price");
            price.textContent = `${products[i].price}kr`;
            li.appendChild(price);

            cart.appendChild(li);
        }

        const total = document.querySelector("#total");
        total.textContent = `Totalsumma: ${cartArr.sum}kr`;
        // cart.innerHTML = content;


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

                const input = e.currentTarget.value.trim();

                // if (isNaN(input) || parseInt(input) < 1) {
                //     e.currentTarget.value = "1";
                // }

                if (input >= 99) {
                    e.currentTarget.value = "99";
                    e.currentTarget.parentElement.parentElement.querySelector(".increase-btn").classList.add("hide");
                    e.currentTarget.parentElement.parentElement.querySelector(".decrease-btn").classList.remove("hide");
                }
                else if (isNaN(input) || parseInt(input) < 1) {
                    e.currentTarget.value = "1";
                    e.currentTarget.parentElement.parentElement.querySelector(".decrease-btn").classList.add("hide");
                    e.currentTarget.parentElement.parentElement.querySelector(".increase-btn").classList.remove("hide");
                } 
                else if (input <= 1) {
                    e.currentTarget.parentElement.parentElement.querySelector(".decrease-btn").classList.add("hide");
                    e.currentTarget.parentElement.parentElement.querySelector(".increase-btn").classList.remove("hide");
                } else {
                    e.currentTarget.value = parseInt(input);
                    e.currentTarget.parentElement.parentElement.querySelector(".increase-btn").classList.remove("hide");
                    e.currentTarget.parentElement.parentElement.querySelector(".decrease-btn").classList.remove("hide");
                }

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
                }

                changeQty(e.currentTarget);
            });
        });

        document.querySelector("#dropCartBtn").addEventListener("click", function(e) {

        })


        function changeQty(input) {

            cartArr.products.forEach(function(element, index) {

                if (element.id === input.dataset.id) {
                    const unitPrice = parseInt(getProductInfo(element.id).price);

                    cartArr.sum = parseInt(cartArr.sum) - parseInt(element.qty) * unitPrice + parseInt(input.value) * unitPrice;
                    element.qty = input.value;
                    element.price = input.value * unitPrice;
                    input.parentElement.parentElement.querySelector(".price").textContent = `${element.price}kr`;
                }

                input.value <= 1 ? input.parentElement.parentElement.querySelector(".decrease-btn").classList.add("hide") : input.parentElement.parentElement.querySelector(".decrease-btn").classList.remove("hide");
            });

            total.textContent = `Totalsumma: ${cartArr.sum}kr`;

            localStorage.setItem("cartArr", JSON.stringify(cartArr));
        }

        function decreaseEvent(btn) {

            cartArr.products.forEach((element, index) => {

                if (element.id === btn.dataset.id) {
                    const unitPrice = parseInt(getProductInfo(element.id).price);

                    element.qty = parseInt(element.qty) - 1;
                    element.price = parseInt(element.price) - unitPrice;
                    cartArr.sum = parseInt(cartArr.sum) - parseInt(unitPrice);
                    
                    btn.nextElementSibling.value = element.qty;
                    btn.parentElement.parentElement.querySelector(".price").textContent = `${element.price}kr`;
                    if (element.qty < 99) btn.parentElement.parentElement.querySelector(".increase-btn").classList.remove("hide");
                    if (element.qty <= 1) btn.classList.add("hide");
                }
            });

            total.textContent = `Totalsumma: ${cartArr.sum}kr`;

            localStorage.setItem("cartArr", JSON.stringify(cartArr));
        }

        function increaseEvent(btn) {

            cartArr.products.forEach((element, index) => {

                if (element.id === btn.dataset.id) {
                    const unitPrice = parseInt(getProductInfo(element.id).price);

                    element.qty = parseInt(element.qty) + 1;
                    element.price = parseInt(element.price) + unitPrice;
                    cartArr.sum = parseInt(cartArr.sum) + parseInt(unitPrice);
                    
                    btn.previousElementSibling.value = element.qty;
                    btn.parentElement.parentElement.querySelector(".price").textContent = `${element.price}kr`;
                    if (element.qty > 1) btn.parentElement.parentElement.querySelector(".decrease-btn").classList.remove("hide");
                    if (element.qty >= 99) btn.classList.add("hide");
                }
            });

            total.textContent = `Totalsumma: ${cartArr.sum}kr`;

            localStorage.setItem("cartArr", JSON.stringify(cartArr));
        }

        function deleteEvent(btn) {

            cartArr.products.forEach((element, index) => {

                if (element.id === btn.dataset.id) {
                    cartArr.sum = parseInt(cartArr.sum) - parseInt(element.price);
                    cartArr.products.splice(index, 1);
                }
            });

            listItem = btn.parentElement;
            listItem.parentElement.removeChild(listItem);
            total.textContent = `Totalsumma: ${cartArr.sum}`;

            localStorage.setItem("cartArr", JSON.stringify(cartArr));
        }
    
        function getProductInfo(productID) {
            return json.find(element => element.id === productID);
        }
    })
    .catch(error => console.error(error));