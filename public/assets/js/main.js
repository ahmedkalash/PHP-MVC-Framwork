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