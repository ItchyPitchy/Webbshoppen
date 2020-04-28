const searchInput = document.querySelector(".search-input");

let searchArr = document.querySelectorAll(".order-ul");

console.log(searchArr);

searchInput.addEventListener("input", function () {
  for (let x = 0; x < searchArr.length; x++) {
    let cityNum = document.getElementById(`${x}city`);
    let city = cityNum.innerHTML;
    const searchWord = event.currentTarget.value.toLowerCase();
    if (city.toLowerCase().includes(searchWord) == false) {
      let ul = document.getElementById(`${x}ul`);
      ul.classList.add("hide");
    } else {
      document.getElementById(`${x}ul`).classList.remove("hide");
    }
  }
});
