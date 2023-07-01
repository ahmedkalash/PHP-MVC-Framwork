function hideElements(ElementsIds) {
    for (var key in ElementsIds){
        document.getElementById(ElementsIds[key]).style.display = 'none';
    }
}

function showElement(elementId) {
    inputGroup = document.getElementById(elementId);
    inputGroup.style.display = 'block';
}

function disableDivsInputElements(DivsIds) {
    for (var key in DivsIds){
         inputGroup = document.getElementById(DivsIds[key]);
         inputElements = inputGroup.querySelectorAll('input');
        for (var inputElement of inputElements) {
            inputElement.disabled=true;
        }
    }
}

function enableDivsInputElements(DivsIds) {
    for (var key in DivsIds){
        inputGroup = document.getElementById(DivsIds[key]);
        inputElements = inputGroup.querySelectorAll('input');
         for (var inputElement of inputElements) {
            inputElement.disabled=false;
        }
    }
}




function typeSwitch (){
    ids= {'dvd': 'dvd-input', 'book': 'book-input', 'furniture': 'furniture-input'};
    hideElements(ids);
    disableDivsInputElements(ids);


    input = document.getElementById('productType');
    targetID = ids[input.value] ;
    showElement(targetID ); 
    enableDivsInputElements([targetID]);

}


function clearOldErrorElements() {
    let errorElements = document.getElementsByClassName('text-red');
    for (let errorElement of errorElements) {
        errorElement.innerText='';
    }

}

function submitForm(formID) {

    var form = document.getElementById(formID);
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        clearOldErrorElements();

        var formData = new FormData(form);

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
                console.log(data); /* *------------------*/
                if (data.status===200) {
                    window.location.href = data.location;
                } else {
                    for(name in data.errors){
                        errorElement = document.getElementById(name+"-error");
                        errorElement.innerText = '* '+data.errors[name];
                    }

                }

            })

    });

}

