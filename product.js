fetch("http://localhost/Webbshoppen/api.php")
    .then(response => response.json())
    .then(json => {

        const productID = new URLSearchParams(window.location.search).get("id");
        const productInfo = getProductInfo(json);
        console.log(productInfo);

        const qtyInput = document.querySelector("#qtyInput")
        
        qtyInput.addEventListener("input", function(e) {
            const inputValue = parseInt(e.currentTarget.value);

            if (isNaN(inputValue)) {
                e.currentTarget.value = "";
            } else if (inputValue > 99) {
                e.currentTarget.value = "99";
            } else if (inputValue <= 1) {
                e.currentTarget.value = inputValue < 1 ? "1" : inputValue;
            } else {
                e.currentTarget.value = inputValue;
            }
        })

        qtyInput.addEventListener("keypress", function(e) {
            
            if (e.which < 48 || e.which > 57) {
                e.preventDefault();
            }

        });

        qtyInput.addEventListener("blur", function(e) {
            const inputValue = e.currentTarget.value.trim();

            if (inputValue === "") {
                e.currentTarget.value = "1";
            }

        });

        qtyInput.addEventListener("focus", function(e) {
            // const inputValue = e.currentTarget.value;
            // e.currentTarget.value = inputValue === "1" ? "" : inputValue;
            e.currentTarget.value = "";
        })

        document.querySelector("#addBtn").addEventListener("click", function(e) {
            // const cartArr = localStorage.getItem("cartArr") === null ? {products: [], sum: 0} : JSON.parse(localStorage.getItem("cartArr"));
            orderCheck(parseInt(document.querySelector("#qtyInput").value));
            // const inputValue = parseInt(document.querySelector("#qtyInput").value);
            // const product = duplicateExists(productID);
            // const qtyInCart = product ? product.qty : 0;

            // if (inputValue + qtyInCart <= parseInt(productInfo.stock)) {
            //     addToCart(inputValue);
            // } else {
            //     document.querySelector("#stock-alert").classList.remove("hide");
                
            //     setTimeout(function() {
            //         document.querySelector("#stock-alert").classList.add("hide");
            //     }, 1000);

            //     e.preventDefault();
            // }
        });
        
        function orderCheck(qty) {
            const cartArr = localStorage.getItem("cartArr") === null ? {products: [], sum: 0} : JSON.parse(localStorage.getItem("cartArr"));
            const product = getDuplicate(cartArr.products);
            const totalQty = product ? qty + product.qty : qty;
            console.log(totalQty);
            
            if (totalQty <= parseInt(productInfo.stock)) {

                if (totalQty <= 99) {
                    product ? mergeProduct(cartArr, qty) : addProduct(cartArr, qty);
                    document.querySelector("#qtyInput").value = "1";

                } else {
                    document.querySelector("#maxLimitAlert").classList.remove("hide");
                
                    setTimeout(function() {
                        document.querySelector("#maxLimitAlert").classList.add("hide");
                    }, 2000);
                    
                }

            } else {
                document.querySelector("#stockAlert").classList.remove("hide");
                
                setTimeout(function() {
                    document.querySelector("#stockAlert").classList.add("hide");
                }, 2000);

            }
        }
    
        function addProduct(cartArr, qty) {
            cartArr.products.unshift({id: productID, name: productInfo.name, qty: qty, price: qty * productInfo.price, image: productInfo.images[0]});
            cartArr.sum = cartArr.sum + qty * productInfo.price;
            localStorage.setItem("cartArr", JSON.stringify(cartArr));
        }

        function mergeProduct(cartArr, qty) {
            cartArr.products.forEach((element, index) => {
                if (element.id === productID) {
                    const qtySum = parseInt(element.qty) + parseInt(qty);
                    const priceSum = parseInt(element.price) + qty * parseInt(productInfo.price);
    
                    cartArr.products.splice(index, 1, {id: productID, name: productInfo.name, qty: qtySum, price: priceSum, image: productInfo.images[0]});
                    cartArr.sum = parseInt(cartArr.sum) + qty * parseInt(productInfo.price);
                }
            });
            localStorage.setItem("cartArr", JSON.stringify(cartArr));
        }
        
        
        
        function getDuplicate(products) {
            return products.find(element => element.id === productID);
        }
    
        function getProductInfo(json) {
            return json.find(element => element.id === productID);
        }
    })
    .catch(error => console.error(error));