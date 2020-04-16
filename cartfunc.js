fetch("http://localhost/Webbshoppen/api.php")
    .then(response => response.json())
    .then(json => {

        console.log(json);
        const productID = document.querySelector("#productID").value;
        const productInfo = getProductInfo(productID, json);

        document.querySelector("#addBtn").addEventListener("click", function(e) {
            addToCart();
        });
        
        function addToCart() {

            if (localStorage.getItem("cartArr") === null)  localStorage.setItem("cartArr", JSON.stringify({products: [], sum: 0}));
            
            const cartArr = JSON.parse(localStorage.getItem("cartArr"));
            const qtyInput = document.querySelector("#quantityInput");
        
            if (duplicateExists(cartArr.products, productID)) {
                mergeProduct(cartArr, productID, qtyInput.value);
            } else {
                addProduct(cartArr, productID, qtyInput.value);
            }
        }
    
        function mergeProduct(cartArr, productID, qty) {
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
        
        function addProduct(cartArr, productID, qty) {
            cartArr.products.unshift({id: productID, name: productInfo.name, qty: qty, price: qty * parseInt(productInfo.price), image: productInfo.images[0]});
            cartArr.sum = parseInt(cartArr.sum) + qty * parseInt(productInfo.price);
            localStorage.setItem("cartArr", JSON.stringify(cartArr));
        }
        
        function duplicateExists(products, targetProduct) {
            return products.find(element => element.id === targetProduct);
        }
    
        function getProductInfo(productID, json) {
            return json.find(element => element.id === productID);
        }
    })
    .catch(error => console.error(error));