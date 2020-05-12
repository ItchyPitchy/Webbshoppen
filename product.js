const productID = new URLSearchParams(window.location.search).get("id")
const productName = document.querySelector(".productName").textContent
const unitPrice = parseInt(document.querySelector("#price").textContent)
const inStock = parseInt(document.querySelector("#stock").textContent)
const img = document.querySelector(".search-img")
const imgUrl = img ? img.getAttribute("src") : ""
let discount = 0

if (document.querySelector("#discount")) {
    discount = parseInt(document.querySelector("#discount").textContent)
}

const qtyInput = document.querySelector("#qtyInput")

qtyInput.addEventListener("input", function(e) {
    const inputValue = parseInt(e.currentTarget.value)

    if (isNaN(inputValue)) {
        e.currentTarget.value = ""
    } else if (inputValue > inStock) {
        e.currentTarget.value = inStock
    } else if (inputValue <= 1) {
        e.currentTarget.value = inputValue < 1 ? "1" : inputValue
    } else {
        e.currentTarget.value = inputValue
    }
})

qtyInput.addEventListener("keypress", function(e) {
    if (e.which < 48 || e.which > 57) {
        e.preventDefault()
    }
})

qtyInput.addEventListener("blur", function(e) {
    const inputValue = e.currentTarget.value.trim()

    if (inputValue === "") {
        e.currentTarget.value = "1"
    }
})

qtyInput.addEventListener("focus", function(e) {
    document.querySelector("#stockAlert").classList.add("hide")
    e.currentTarget.value = ""
})

document.querySelector("#addBtn").addEventListener("click", function(e) {
    orderCheck(parseInt(qtyInput.value))
})

function orderCheck(qty) {
    const cartArr =
        localStorage.getItem("cartArr") === null
            ? { products: [], sum: 0, totalDiscountSum: 0 }
            : JSON.parse(localStorage.getItem("cartArr"))
    const product = getDuplicate(cartArr.products)
    const totalQty = product ? qty + product.qty : qty

    if (totalQty <= inStock) {
        product ? mergeProduct(cartArr, qty) : addProduct(cartArr, qty)
        document.querySelector("#qtyInput").value = "1"
        document.querySelector("#header-cart").style = "fill: red;"
    } else {
        document.querySelector("#stockAlert").classList.remove("hide")
    }
}

function addProduct(cartArr, qty) {
    console.log("addProduct körs")
    cartArr.products.unshift({
        id: productID,
        name: productName,
        qty: qty,
        unitPrice: unitPrice,
        image: imgUrl,
        stock: inStock,
        discount: discount
    })
    cartArr.sum = cartArr.sum + qty * unitPrice
    cartArr.totalDiscountSum = cartArr.totalDiscountSum + qty * discount
    localStorage.setItem("cartArr", JSON.stringify(cartArr))
    console.log("cartArr", cartArr)
}

function mergeProduct(cartArr, qty) {
    cartArr.products.forEach((element, index) => {
        if (element.id === productID) {
            const qtySum = element.qty + qty

            cartArr.products.splice(index, 1, {
                id: productID,
                name: productName,
                qty: qtySum,
                unitPrice: unitPrice,
                image: imgUrl,
                stock: inStock,
                discount: discount
            })
            cartArr.sum = cartArr.sum + qty * unitPrice
            cartArr.totalDiscountSum = cartArr.totalDiscountSum + qty * discount
        }
    })
    localStorage.setItem("cartArr", JSON.stringify(cartArr))
}

function getDuplicate(products) {
    return products.find(element => element.id === productID)
}
