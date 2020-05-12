const addBtns = document.querySelectorAll(".addToCartBtn")

if (
    localStorage.getItem("cartArr") !== null &&
    JSON.parse(localStorage.getItem("cartArr")).products.length !== 0
) {
    const cartProducts = JSON.parse(localStorage.getItem("cartArr")).products

    cartProducts.forEach(function(element) {
        const btns = document.querySelectorAll(
            `button[data-id="${element.id}"]`
        )

        if (btns) {
            btns.forEach(function(element) {
                element.textContent = "Produkten är tillagd"
            })
        }
    })
}

addBtns.forEach(function(element) {
    element.addEventListener("click", function(e) {
        orderCheck(e.currentTarget)
    })
})

function orderCheck(btn) {
    const cartArr =
        localStorage.getItem("cartArr") === null
            ? { products: [], sum: 0, totalDiscountSum: 0 }
            : JSON.parse(localStorage.getItem("cartArr"))

    if (!getDuplicate(cartArr.products, btn)) {
        addProduct(cartArr, btn)

        const btns = document.querySelectorAll(
            `button[data-id="${btn.dataset.id}"]`
        )

        btns.forEach(function(element) {
            element.textContent = "Produkten är tillagd"
        })

        document.querySelector("#header-cart").style = "fill: aquamarine;"
    }
}

function addProduct(cartArr, btn) {
    cartArr.products.unshift({
        id: btn.dataset.id,
        name: btn.dataset.name,
        qty: 1,
        unitPrice: parseInt(btn.dataset.price),
        image: btn.dataset.image,
        stock: parseInt(btn.dataset.stock),
        discount: parseInt(btn.dataset.discount)
    })
    cartArr.sum = cartArr.sum + parseInt(btn.dataset.price)
    //Vanessa
    cartArr.totalDiscountSum =
        cartArr.totalDiscountSum + parseInt(btn.dataset.discount)
    localStorage.setItem("cartArr", JSON.stringify(cartArr))
}

function getDuplicate(products, btn) {
    return products.find(element => element.id === btn.dataset.id)
}
