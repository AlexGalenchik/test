

let buttonshow = document.querySelector('#buttonshow');
let addFilter = document.querySelector('#addFilter');



buttonshow.onclick = function () {
    addFilter.classList.toggle('hideandshow');
    // buttonshow.addCla.toggle('buttonshow');
    buttonshow.classList.toggle('buttonshow');
}

// console.log(buttonshow.style.transform);

// setTimeout(function(){ addFilter.classList.toggle('hideandshow'); }, 3000);


