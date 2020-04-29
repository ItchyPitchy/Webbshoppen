/***********************************Sök funktion*********************************** */

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
      ul.classList.add("searchHide");
    } else {
      document.getElementById(`${x}ul`).classList.remove("searchHide");
    }
  }
});

/***********************************filtrera radio btn funktion*********************************** */

radioBtnAll = document.querySelector("#alla");
radioBtnNew = document.querySelector("#nya");
radioBtnInProg = document.querySelector("#behandlade");
radioBtnCompleted = document.querySelector("#slutförda");

firstContainer = document.querySelector(".firstContainer");
secondContainer = document.querySelector(".secondContainer");

radioBtnCompleted.addEventListener("click", function () {
  console.log(radioBtnCompleted.value);
  if (radioBtnCompleted.value == "on") {
    for (let x = 0; x < searchArr.length; x++) {
      let ul = document.getElementById(`${x}ul`);
      ul.classList.remove("hide");
    }
    firstContainer.classList.add("hide");
    secondContainer.classList.remove("hide");
    document.querySelector(".activeH2").classList.add("hide");
    document.querySelector(".secondHeadingOrders").classList.remove("hide");
  }
});

radioBtnAll.addEventListener("click", function () {
  if (radioBtnAll.value == "on") {
    firstContainer.classList.remove("hide");
    secondContainer.classList.remove("hide");
    document.querySelector(".activeH2").classList.remove("hide");
    document.querySelector(".secondHeadingOrders").classList.remove("hide");

    for (let x = 0; x < searchArr.length; x++) {
      let ul = document.getElementById(`${x}ul`);
      ul.classList.remove("hide");
      ul.classList.remove("filterHide");
    }
  }
});

radioBtnNew.addEventListener("click", function () {
  console.log(radioBtnNew.value);
  if (radioBtnNew.value == "on") {
    firstContainer.classList.remove("hide");
    secondContainer.classList.add("hide");
    document.querySelector(".activeH2").classList.remove("hide");
    document.querySelector(".secondHeadingOrders").classList.add("hide");
    for (let x = 0; x < searchArr.length; x++) {
      let statusTag = document.getElementById(`${x}select`);
      let status = statusTag.value;
      console.log(status);
      if (status == 1) {
        let ul = document.getElementById(`${x}ul`);
        ul.classList.add("filterHide");
      } else {
        document.getElementById(`${x}ul`).classList.remove("filterHide");
      }
    }
  }
});

radioBtnInProg.addEventListener("click", function () {
  if (radioBtnNew.value == "on") {
    firstContainer.classList.remove("hide");
    secondContainer.classList.add("hide");
    document.querySelector(".activeH2").classList.remove("hide");
    document.querySelector(".secondHeadingOrders").classList.add("hide");

    for (let x = 0; x < searchArr.length; x++) {
      let statusTag = document.getElementById(`${x}select`);
      let status = statusTag.value;
      console.log(status);
      if (status == 0) {
        let ul = document.getElementById(`${x}ul`);
        ul.classList.remove("hide");
        ul.classList.add("filterHide");
      } else {
        document.getElementById(`${x}ul`).classList.remove("filterHide");
      }
    }
  }
});
