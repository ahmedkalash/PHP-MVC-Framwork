let ids = {'DVD': 'dvd-input', 'Book': 'book-input', 'Furniture': 'furniture-input'};

if (window.location.pathname==='/') {
    window.onload = getAllProducts;
}
if(document.getElementById('productType')!==null){
    window.onload= function (){
        let switcher = document.getElementById('productType');
        if(switcher!==null  ){
            let typeID = switcher.options[switcher.selectedIndex].id;
            if( typeof typeID !== 'undefined' && typeID.trim().length !==0){
                showElement(ids[typeID]);
                enableDivsInputElements({"${typeID}":ids[typeID]})
            }
        }
    }
}

function redirect(to){
    window.location=to;
}

function hideElements(ElementsIds) {
    for (var key in ElementsIds){
        document.getElementById(ElementsIds[key]).style.display = 'none';
    }
}

function showElement(elementId) {
    let inputGroup = document.getElementById(elementId);
    inputGroup.style.display = 'block';
}

function disableDivsInputElements(DivsIds) {

    let inputGroup;
    let inputElements;
    for (let key in DivsIds) {
        inputGroup = document.getElementById(DivsIds[key]);
        inputElements = inputGroup.querySelectorAll('input');
        for (let inputElement of inputElements) {
            inputElement.disabled = true;
        }
    }
}

function enableDivsInputElements(DivsIds) {
    let inputGroup;
    let inputElements;
    for (let key in DivsIds) {
        inputGroup = document.getElementById(DivsIds[key]);
        inputElements = inputGroup.querySelectorAll('input');
        for (var inputElement of inputElements) {
            inputElement.disabled = false;
        }
    }
}



if(document.getElementById('productType') !== null){
    document.getElementById('productType').onchange = function () {
        hideElements(ids);
        disableDivsInputElements(ids);


        let targetID = ids[(this.options[this.selectedIndex]).id];
        showElement(targetID);
        enableDivsInputElements([targetID]);

    }

}



function clearOldErrorElements() {
    let errorElements = document.getElementsByClassName('text-red');
    for (let errorElement of errorElements) {
        errorElement.innerText='';
    }

}

function submitAddProductForm(formID) {
    let form = document.getElementById(formID);
    clearOldErrorElements();
    let formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        headers: {
            'Accept': 'application/json'
        },
        body: formData
    }).then(function(response) {
        return response.json();
    })
        .then(function(data) {
            let errorElement;
            if (data.status === 200) {
                redirect(data.location);
            } else {
                for (let name in data.errors) {
                    errorElement = document.getElementById(name + "-error");
                    errorElement.innerText = '* ' + data.errors[name];
                }
            }

        })

}


function getAllProducts() {
    let url = '/api/v1/products';
    fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        },
    }).then(function(response) {
        return response.json();
    }).then(function(data) {
        let card;
        if (data.status === 200) {
            let containerForm = document.getElementById('delete_form');
            card = document.getElementById('product-card');
            document.getElementById('product-card').remove();
            card.removeAttribute('id');
            for (let product of data.products.list) {
                let productCard = card.cloneNode(true);
                productCard.setAttribute('id', product.id);
                productCard.querySelector('.delete-checkbox').setAttribute('value', product.id);
                productCard.querySelector('.info').innerHTML += ("<h1>" + product.sku + "</h1>");
                productCard.querySelector('.info').innerHTML += (`<h1> ${product.name} </h1>`);
                productCard.querySelector('.info').innerHTML += (`<h1>$ ${product.price}</h1>`);
                for (let attribute in product.attributes) {
                    productCard.querySelector('.info').innerHTML += (`<h1> ${attribute} ${product.attributes[attribute]['value']} ${product.attributes[attribute]['unit']}</h1>`);
                }
                containerForm.append(productCard);
            }
        } else {
            for (let name of data.errors) {
                window.log(name);
            }
        }

    })

}


function massDelete(formID) {
    let form = document.getElementById(formID);

    let formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        headers: {
            'Accept': 'application/json'
        },
        body: formData
    }).then(function(response) {
        return response.json();
    }).then(function(data) {
        let ids;
        if (data.status === 200) {
            ids = formData.getAll('ids[]');
            for (let id of ids) {
                document.getElementById(id).remove();
            }

        } else {
            for (let name in data.errors) {
                window.log(name);
            }
        }

    })

}





function validateDecimal(decimalNum, integerPartLength, decimalPartLength) {
    decimalNum =parseFloat(decimalNum.toString().trim());

    let arrNum;

    let strNum = decimalNum.toString();
    arrNum = strNum.split('.');
    //console.log((arrNum[1].length)??0)

    let integerPart = arrNum[0] ?? 0;
    let decimalPart = arrNum[1] ?? 0;

    if (integerPart.toString().length > integerPartLength || (decimalPart.toString().length) > decimalPartLength ) {
        return false
    }

}

