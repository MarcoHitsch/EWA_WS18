function pizzaImageClickHandler(pizzaID, pizzaName, pizzaPrice) {
    console.log("Handler " + pizzaName);
        var warenkorb = document.getElementById("warenkorb_select");
        // var newId = warenkorb.getElementsByTagName("option").length;
        // var opt = document.createElement('option');

        opt = new Option(pizzaName, pizzaID);
        opt.setAttribute('data-price', pizzaPrice);

        // opt.id = pizzaID;
        // opt.value = pizzaName;
        // opt.setAttribute("data-price", pizzaPrice);
        // opt.textContent = "Pizza " + pizzaName;
        // warenkorb.appendChild(opt);
        warenkorb[warenkorb.length] = opt;

        var priceTag = document.getElementById("warenkorb_price");
        var totalPrice = parseFloat(priceTag.textContent) + parseFloat(pizzaPrice);
        priceTag.textContent = totalPrice;
};

function checkSubmit() {
    var warenkorb = document.getElementById("warenkorb_select");
    if (warenkorb.options.length == 0) {
        alert("Es ist keine Pizza im Warenkorb.")
        return false;
    }
    else {
        var warenkorb = document.getElementById("warenkorb_select");
        var opts = warenkorb.getElementsByTagName("option");

        for (var i = opts.length - 1; i >= 0; i--) {
            opts[i].selected = true;
        }
        return true;
    }

};

function deleteSelectedWarenkorb() {
    var warenkorb = document.getElementById("warenkorb_select");
    var opts = warenkorb.getElementsByTagName("option");
    var priceTag = document.getElementById("warenkorb_price");
    var totalPrice = parseFloat(priceTag.textContent);

    for (var i = opts.length - 1; i >= 0; i--) {
        if (opts[i].selected) {
            totalPrice -= parseFloat(opts[i].getAttribute("data-price"));
            console.log(totalPrice);
            warenkorb.remove(i);
        }
    }
    priceTag.textContent = totalPrice;
};

function deleteAllWarenkorb() {
    var warenkorb = document.getElementById("warenkorb_select");
    var priceTag = document.getElementById("warenkorb_price");

    warenkorb.options.length = 0;
    priceTag.textContent = "0";
};




// Setup Pizza Klick in Warenkorb
var list = document.getElementById("pizzaList");
var items = list.getElementsByTagName("div");
for (var i = 0; i < items.length; i++) {
    var pizzaValue = items[i].getAttribute("data-pizza");
    items[i].addEventListener("click",
        function () {
            pizzaImageClickHandler(this.getAttribute('data-id'), this.getAttribute("data-name"), this.getAttribute("data-price"));
        });
};

// Setup Warenkorb leeren Buttons
var btn_DeleteAll = document.getElementById("button_deleteAll");
var btn_DeleteSelected = document.getElementById("button_deleteSelected");

btn_DeleteSelected.onclick = function () { deleteSelectedWarenkorb(); };
btn_DeleteAll.onclick = function () { deleteAllWarenkorb(); };


// Setup Order Button Disabled
var btn_order = document.getElementById("button_order");
var input_Adresse = document.getElementById("input_adresse");
btn_order.disabled = true;
input_Adresse.addEventListener('input', function (e) {
    var button_order = document.getElementById("button_order");
    button_order.disabled = this.value == "";
});