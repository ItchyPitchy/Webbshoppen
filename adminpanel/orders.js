/***********************************Sök funktion*********************************** */

const searchInput = document.querySelector(".search-input");

let searchArr = document.querySelectorAll(".order-ul");

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

let divUlArr = firstContainer.children;
let divUlArrComplete = secondContainer.children;

radioBtnCompleted.addEventListener("click", function () {
  if (radioBtnCompleted.value == "on") {
    for (let x = 0; x < searchArr.length; x++) {
      let ul = document.getElementById(`${x}ul`);
      ul.classList.remove("hide");
    }
    firstContainer.classList.add("hide");
    secondContainer.classList.remove("hide");
    document.querySelector(".activeH2").classList.add("hide");
    document.querySelector(".activeTbHeading").classList.add("hide");

    document.querySelector(".secondHeadingOrders").classList.remove("hide");
    document.querySelector(".completedTbHeading").classList.remove("hide");
  }
});

radioBtnAll.addEventListener("click", function () {
  if (radioBtnAll.value == "on") {
    firstContainer.classList.remove("hide");
    secondContainer.classList.remove("hide");
    document.querySelector(".activeH2").classList.remove("hide");
    document.querySelector(".activeTbHeading").classList.remove("hide");
    document.querySelector(".secondHeadingOrders").classList.remove("hide");
    document.querySelector(".completedTbHeading").classList.remove("hide");

    for (let x = 0; x < searchArr.length; x++) {
      let ul = document.getElementById(`${x}ul`);
      ul.classList.remove("hide");
      ul.classList.remove("filterHide");
    }
  }
});

radioBtnNew.addEventListener("click", function () {
  if (radioBtnNew.value == "on") {
    firstContainer.classList.remove("hide");
    secondContainer.classList.add("hide");
    document.querySelector(".activeTbHeading").classList.remove("hide");
    document.querySelector(".activeH2").classList.remove("hide");
    document.querySelector(".secondHeadingOrders").classList.add("hide");
    document.querySelector(".completedTbHeading").classList.add("hide");

    for (let x = 0; x < divUlArr.length; x++) {
      let statusTag = document.getElementById(`${x}select`);
      let status = statusTag.value;
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
    document.querySelector(".activeTbHeading").classList.remove("hide");
    document.querySelector(".activeH2").classList.remove("hide");
    document.querySelector(".secondHeadingOrders").classList.add("hide");
    document.querySelector(".completedTbHeading").classList.add("hide");

    for (let x = 0; x < divUlArr.length; x++) {
      let statusTag = document.getElementById(`${x}select`);
      let status = statusTag.value;
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

/***********************************sortera dropdown funktion*********************************** */

const originalArr = Array.from(divUlArr);
var revArr = originalArr.slice().reverse();
const originalArrComplete = Array.from(divUlArrComplete);
var revArrComplete = originalArrComplete.slice().reverse();

let selected = "";

sortSelect = document.querySelector("#sort");
sortSelect.addEventListener("change", function () {
  dateArr = [];

  /***************senaste/äldsta beställningarna****************** */

  if (sortSelect.value == "senaste") {
    selected = "senaste";
    firstContainer.innerHTML = "";
    secondContainer.innerHTML = "";

    for (let x = 0; x < originalArr.length; x++) {
      firstContainer.appendChild(revArr[x]);
    }
    for (let x = 0; x < originalArrComplete.length; x++) {
      secondContainer.appendChild(revArrComplete[x]);
    }
  } else if (sortSelect.value == "äldsta") {
    firstContainer.innerHTML = "";
    secondContainer.innerHTML = "";

    for (let x = 0; x < originalArr.length; x++) {
      firstContainer.appendChild(originalArr[x]);
    }
    for (let x = 0; x < originalArrComplete.length; x++) {
      secondContainer.appendChild(originalArrComplete[x]);
    }
    selected = "äldsta";
  }

  /***************Nya/Behandlade beställningarna****************** */

  if (sortSelect.value == "nya") {
    for (let x = 0; x < originalArr.length; x++) {
      if (document.getElementById(`${x}select`).value == 0) {
        let ul = document.getElementById(`${x}ul`);
        ul.remove();
        firstContainer.prepend(ul);
      }
    }
  }

  if (sortSelect.value == "behandlas") {
    for (let x = 0; x < originalArr.length; x++) {
      if (document.getElementById(`${x}select`).value == "1") {
        let ul = document.getElementById(`${x}ul`);
        ul.remove();
        firstContainer.prepend(ul);
      }
    }
  }

  /***************dyraste/billigaste beställningarna****************** */

  if (sortSelect.value == "billigaste") {
    ulArr = Array.from(divUlArr);
    ulArr.sort(function (a, b) {
      return (
        parseInt(a.querySelector(".price").innerHTML) -
        parseInt(b.querySelector(".price").innerHTML)
      );
    });
    firstContainer.innerHTML = "";

    for (let x = 0; x < ulArr.length; x++) {
      firstContainer.innerHTML += ulArr[x].outerHTML;
    }

    ulArrCom = Array.from(divUlArrComplete);
    ulArrCom.sort(function (a, b) {
      return (
        parseInt(a.querySelector(".priceComplete").innerHTML) -
        parseInt(b.querySelector(".priceComplete").innerHTML)
      );
    });
    secondContainer.innerHTML = "";

    for (let x = 0; x < ulArrCom.length; x++) {
      secondContainer.innerHTML += ulArrCom[x].outerHTML;
    }
  }

  if (sortSelect.value == "dyraste") {
    ulArr = Array.from(divUlArr);

    ulArr.sort(function (a, b) {
      return (
        parseInt(a.querySelector(".price").innerHTML) -
        parseInt(b.querySelector(".price").innerHTML)
      );
    });
    var revUlArr = ulArr.slice().reverse();

    firstContainer.innerHTML = "";

    for (let x = 0; x < revUlArr.length; x++) {
      firstContainer.innerHTML += revUlArr[x].outerHTML;
    }

    ulArrCom = Array.from(divUlArrComplete);

    ulArrCom.sort(function (a, b) {
      return (
        parseInt(a.querySelector(".priceComplete").innerHTML) -
        parseInt(b.querySelector(".priceComplete").innerHTML)
      );
    });
    var revUlArrCom = ulArrCom.slice().reverse();

    secondContainer.innerHTML = "";

    for (let x = 0; x < revUlArrCom.length; x++) {
      secondContainer.innerHTML += revUlArrCom[x].outerHTML;
    }
  }
});
