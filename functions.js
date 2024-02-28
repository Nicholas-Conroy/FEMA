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

//handle submitting of materials given form
document.getElementById("materials-given-form").addEventListener('submit', event => {
    event.preventDefault();

    //serialize form data for sending as POST data
    let formData = new FormData(document.getElementById("materials-given-form"));
    console.log(formData.get('poutine-qty'));

    //send form data to PHP file, and return response if successfully entered in DB or not
    fetch("includes/mgivenformhandler.php", {
        method: 'POST',
        body: formData
    })
    //returning text, not json
    .then(response => response.text())
    .then(message => {

        //invalid data submitted (ex: caused quantity to be negative)
        if(message === "invalid"){
            alert("You have given more than is needed. Relax.");
        }

        window.location.reload();

    })
    .catch(error => {
        console.log(error);
        // alert(error);
    })
});

// TODO

// IDEAS
//  - check that material name from db matches name in table for respective quantity? ensures things are put in the wrong spot instead of just relying on order