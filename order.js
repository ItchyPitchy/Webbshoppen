const cart = document.querySelector("#cart");
const name = document.querySelector("#name");
const zipcode = document.querySelector("#zipcode");
const shipping = document.querySelector("#shipping");

if (localStorage.getItem("cartArr") !== null && JSON.parse(localStorage.getItem("cartArr")).products.length !== 0) {
    const cartArr = JSON.parse(localStorage.getItem("cartArr"));
    const products = cartArr.products;
    document.querySelector("#total").textContent = `Totalsumma: ${cartArr.sum} kr`;
    document.querySelector("#json").value = localStorage.getItem("cartArr");

    for (let i = 0; i < cartArr.products.length; i++) {

        const li = document.createElement("li");
        
        const productImage = document.createElement("img");
        productImage.setAttribute("src", products[i].image);
        productImage.classList.add("product-image");
        li.appendChild(productImage);

        const productTitle = document.createElement("span");
        productTitle.classList.add("product-title");
        productTitle.textContent = products[i].name;
        li.appendChild(productTitle);

        const qty = document.createElement("span");
        qty.textContent = `${products[i].qty} st`;
        li.appendChild(qty);

        const price = document.createElement("span");
        price.classList.add("price");
        price.textContent = `${products[i].unitPrice * products[i].qty} kr`;
        li.appendChild(price);

        cart.appendChild(li);
    }


    if (cartArr.sum > 500) {
        shipping.style = "text-decoration: line-through;"
    }
    
    document.querySelector("#phone").addEventListener("keypress", function(e) {

        if (e.which < 48 || e.which > 57) {
            e.preventDefault();
        }
    })

    const city = document.querySelector("#city");
    
    city.addEventListener("input", function(e) {
        
        if (e.currentTarget.value.trim().toLowerCase() === "stockholm") {
            shipping.style = "text-decoration: line-through;"
        } else if (cartArr.sum <= 500) {
            shipping.style = "text-decoration: none;"
        }
    });

    city.addEventListener("keypress", function(e) {

        if (e.which >= 48 && e.which <= 57) {
            e.preventDefault();
        }
    });

    name.addEventListener("keypress", function(e) {
    
        if (e.which >= 48 && e.which <= 57) {
            e.preventDefault();
        }
    });

} else {
    total.textContent = "Totalsumma: 0 kr";
    cart.innerHTML = "<h2 class='empty'>Varukorgen är tom</h2><a class='to-start' href='./index.php'>Tillbaka till startsidan</a>";
    const form = document.querySelector("#form");
    form.parentElement.removeChild(form);
    // form.style = "display: none;";
}

function validateForm() {
    const alerts = document.querySelectorAll(".alert");
    let error = false;

    for (let i = 0; i < alerts.length; i++) {
        alerts[i].parentElement.removeChild(alerts[i]);
    }

    if (name.value.trim().length < 2 || name.value.trim().length > 20 || /\d/.test(name.value)) {
        let alert = document.createElement("span");
        alert.classList.add("alert");
        alert.textContent = "Namn måste vara mellan 2-20 tecken";
        name.after(alert);
        error = true;
    }

    if (zipcode.value.trim().split(" ").join("").length !== 5) {
        let alert = document.createElement("span");
        alert.classList.add("alert");
        alert.textContent = "Vänligen ange ett giltigt postnummer";
        zipcode.after(alert);
        error = true;
    }

    if (error) {
        return false;
    } else {
        zipcode.value = zipcode.value.trim().split(" ").join("");
        return true;
    }
}