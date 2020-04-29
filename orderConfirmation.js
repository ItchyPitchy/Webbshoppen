const cart = document.querySelector("#order-ul");

let today = new Date();
let dd = today.getDate();

let mm = today.getMonth() + 1;
let yyyy = today.getFullYear();

if (dd < 10) {
  dd = "0" + dd;
}

if (mm < 10) {
  mm = "0" + mm;
}
today = mm + "-" + dd + "-" + yyyy;

document.getElementById("date").innerHTML = "Datum: " + today;

const customerId = document.querySelector(".customer-id");
customerId.textContent = `Kundnummer: ` + id;

const customerName = document.querySelector(".customer-name");
customerName.textContent = `Kundnamn: ` + name;

const customerEmail = document.querySelector(".customer-email");
customerEmail.textContent = `E-postadress: ` + email;

const customerPhone = document.querySelector(".customer-phone");
customerPhone.textContent = `Telefon: ` + phone;

const customerStreet = document.querySelector(".customer-street");
customerStreet.textContent = `Gatuadress: ` + street;

const customerZipcode = document.querySelector(".customer-zipcode");
customerZipcode.textContent = `Postnummer: ` + zipcode;

const customerCity = document.querySelector(".customer-city");
customerCity.textContent = `Ort: ` + city;

if (
  localStorage.getItem("cartArr") !== null &&
  JSON.parse(localStorage.getItem("cartArr")).products.length !== 0
) {
  const cartArr = JSON.parse(localStorage.getItem("cartArr"));
  const products = cartArr.products;
  const total = document.querySelector("#total");
  total.textContent = `Totalsumma: ${cartArr.sum} kr`;

  for (let i = 0; i < cartArr.products.length; i++) {
    const li = document.createElement("li");

    const productImage = document.createElement("img");
    productImage.setAttribute("src", products[i].image);
    productImage.classList.add("overview-image");
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

    localStorage.clear();
    
    document.querySelector("#header-cart").style = "fill: unset;";
  }
}
