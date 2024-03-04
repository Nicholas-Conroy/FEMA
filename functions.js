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

// handle submitting of materials needed form
document.getElementById("materials-requested-form").addEventListener('submit', event => {
    event.preventDefault();

    /*
        ensure that if a material quantity has been submitted, the respective material name checkbox has been checked,
        and vice versa (checlbox has been checked, must have a quantity selected)
    */
    const materialNames = document.getElementById("materials-requested-form").getElementsByClassName("chkbox");

    for(let i=0; i<materialNames.length; i++){
        let id = materialNames[i].id;
        if (materialNames[i].checked) {
            //all quantity boxes have the same id as the matching material name, with the additon of -qty
            // check if checked boxes have a value for their quantity
            if(document.getElementById(id+"-qty").value == "") {
                alert("You can't do that");
                window.location.reload();
                return;
            }
        }
        else {
            // check if unchecked boxes have no value for their quantity
            if(document.getElementById(id+"-qty").value != "") {
                alert("You can't do that");
                window.location.reload();
                return;
            }
        }
    }
    //serialize form data for sending as POST data
    let formData = new FormData(document.getElementById("materials-requested-form"));

   //send form data to PHP file, and return response if successfully entered in DB or not
    fetch("includes/mneededformhandler.php", {
        method: 'POST',
        body: formData
    })
    //returning text, not json
    .then(response => response.text())
    .then(message => {

        console.log(message);
        window.location.reload();

    })
    .catch(error => {
        console.log(error);
        // alert(error);
    })

});

//handle submitting of materials given form
document.getElementById("materials-given-form").addEventListener('submit', event => {
    event.preventDefault();

     /*
        ensure that if a material quantity has been submitted, the respective material name checkbox has been checked,
        and vice versa (checlbox has been checked, must have a quantity selected)
    */
        const materialNames = document.getElementById("materials-given-form").getElementsByClassName("chkbox");

        for(let i=0; i<materialNames.length; i++){
            let id = materialNames[i].id;
            if (materialNames[i].checked) {
                //all quantity boxes have the same id as the matching material name, with the additon of -qty
                // check if checked boxes have a value for their quantity
                if(document.getElementById(id+"-qty").value == "") {
                    // console.log('y');
                    alert("You can't do that");
                    window.location.reload();
                    return;
                }
            }
            else {
                // check if unchecked boxes have no value for their quantity
                if(document.getElementById(id+"-qty").value != "") {
                    alert("You can't do that");
                    window.location.reload();
                    return;
                }
            }
        }


    //serialize form data for sending as POST data
    let formData = new FormData(document.getElementById("materials-given-form"));

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

        console.log(message);

        window.location.reload();

    })
    .catch(error => {
        // console.log(error);
        alert(error);
    })
});

// TODO

// IDEAS
//  - check that material name from db matches name in table for respective quantity? ensures things are put in the wrong spot instead of just relying on order