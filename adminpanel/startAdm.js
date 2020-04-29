const inputField = document.querySelector("#category-input");
const lengthCounter = document.querySelector("#input-length-counter");

if (lengthCounter && inputField) { 
    lengthCounter.textContent = 20 - parseInt(inputField.value.length);
    
    inputField.addEventListener("input", function(e) {

        if (e.currentTarget.value.length > 20) {
            e.currentTarget.value = e.currentTarget.value.substring(0, 20);
        }
        lengthCounter.textContent = 20 - parseInt(e.currentTarget.value.length);
    });

}

function validateForm() {
    const inputField = document.querySelector("#category-input");
    const input = inputField.value;
    const alerts = document.querySelectorAll(".alert");
    let error = false;

    for (let i = 0; i < alerts.length; i++) {
        alerts[i].parentElement.removeChild(alerts[i]);
    }

    if (input.trim().length === 0 || input.trim().length > 20) {
        // const alert = document.createElement("span");
        // alert.classList.add("update-error");
        // alert.textContent = "upp till 50 tecken";
        // inputField.after(alert);
        error = true;
    }

    if (error) return false
}