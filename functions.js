window.onload = event => {
    getData();
}


function getData() {
    fetch("includes/data.php", {

    })
    .then(response => response.json())
    .then(data => {
        console.log(data);

        //all table cells that display the quantity needed for a given item
        const itemsList = document.getElementsByClassName("qty-needed");

        //loop through collection of cells
        for (let i=0; i<itemsList.length; i++){
            itemsList.item(i).innerHTML = data[i].quantity_needed;
        }

    })
    .catch(error => {
        console.log(error);
    })
}


// event is automatically passed from eventlistener
function getMessage(event) {
    event.preventDefault();
    fetch("includes/mgivenformhandler.php", {})
    //returning text, not json
    .then(response => response.json())
    .then(data => {
        console.log(data);
        alert(data);

    })
    .catch(error => {
        console.log(error);
        alert(error);
    })
}

document.getElementById("materials-given-form").addEventListener('submit', getMessage);

// TODO

// IDEAS
//  - check that material name from db matches name in table for respective quantity? ensures things are put in the wrong spot instead of just relying on order