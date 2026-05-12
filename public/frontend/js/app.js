function activeImpression(event) {
    //  let impression  = document.getElementById('impression');
    //  impression.classList.toggle('active');

    console.log(event.target.classList.toggle('active'))

}


function slide() {
    let sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
}

function donate() {
    let donation = document.getElementById('donation');
    document.getElementById('continue').style.display = "none";
    donation.classList.toggle('active');
}

function collapsMenu() {
    let menu = document.getElementById('mobileMenu');
    menu.classList.toggle('active');
}

function closeMenu() {
    let menu = document.getElementById('mobileMenu');
    menu.classList.remove('active');
}


function foldSidebar() {
    document.getElementById('leftSidebar').classList.toggle('close')
}

// window.onload = function() {

//     if (window.innerWidth <= 768) {
//         let sidebar = document.getElementById("leftSidebar");
//         sidebar.classList.add('close');
//     }


//     // sidebar nav js
//     var mycls = document.getElementsByClassName('nav-item');
//     for (let i = 0; i <= mycls.length; i++) {
//         mycls[i].addEventListener("click", function() {
//             for (var j = 0; j < mycls.length; j++) {
//                 mycls[j].classList.remove('active');
//             }
//             this.classList.add('active');
//         });
//     }
//     // end
// }


function decrementQty() {
    let quantity = document.getElementById("quantity");
    quantity = parseFloat(quantity.value--);
    quantity = quantity - 1;
}

function increamntQty() {
    let quantity = document.getElementById("quantity");
    quantity = parseFloat(quantity.value++);
    quantity = quantity + 1;

    let product_price = document.getElementById("product_price");
    product_price = parseFloat(product_price.value);
    let price = quantity * product_price;

    let product_total_price = document.getElementById("product_total_price");
    product_total_price.innerHTML = price;
}



document.addEventListener('scroll', function(e) {
    ScrollPosition = window.scrollY;


    if (ScrollPosition > 60) {
        let bottomMenu = document.getElementById("bottom-menu").classList.add("open")
    } else {
        let bottomMenu = document.getElementById("bottom-menu").classList.remove("open")
    }

});


// new js
function mobileViewActive(event) {

    if (event === "logos") {
        let colOne = document.getElementById('colOne').classList.toggle('open');
    }
    if (event === "info") {
        let colOne = document.getElementById('colTwo').classList.toggle('open');
    }
    if (event === "link") {
        let colOne = document.getElementById('colThree').classList.toggle('open');
    }
    if (event === "contact") {
        let colOne = document.getElementById('colFour').classList.toggle('open');
    }
    if (event === "apps") {
        let colOne = document.getElementById('colFive').classList.toggle('open');
    }
}


function catchSize(event) {
    let location = event.target.parentNode.previousElementSibling.value;
    document.getElementById('sizeName').innerHTML = location;
}

function catchColor(event) {
    let location = event.target.parentNode.previousElementSibling.value;
    document.getElementById('colorName').innerHTML = location;
}

function dec() {
    let val = document.getElementById('cartValue').value--;

    if (val <= 0) {
        document.getElementById('dec').disabled = true;
    }
}


function inc() {
    let val = document.getElementById('cartValue').value++;
    if (val >= 0) {
        document.getElementById('dec').disabled = false;
    }
}
