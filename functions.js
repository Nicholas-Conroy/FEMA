window.onload = event => {
    getData();
    getPersons();
}

function getData() {
    fetch("includes/data.php", {

    })
    .then(response => response.json())
    .then(data => {
        console.log(data);

        //counter to keep track of number of rows hidden
        let rowHiddenCounter = 0;

        //all table rows in table that displays what materials are needed
        const itemsList = document.getElementsByClassName("needed-table-row");

        //loop through collection of rows
        for (let i=0; i<itemsList.length; i++){
            const currentRow = itemsList.item(i);
            const qty_cell = currentRow.getElementsByClassName("qty-needed").item(0); //only one qty-needed class item in each row

            //if data for respective row quantity is 0, then remove row
            if(data[i].quantity_needed == 0){
                currentRow.style.display = "none";
                rowHiddenCounter++;
            }
            else {
                qty_cell.innerHTML = data[i].quantity_needed;
            }
        }

        //if all rows have been hidden, then display message informing users that no items are currently needed
        if(rowHiddenCounter == itemsList.length){
            document.getElementById("message-row").style.display = "table-row";
            document.getElementById("empty-message").innerHTML = "There are no items needed right now!";
        }

    })
    .catch(error => {
        console.log(error);
    })
}

function getPersons(){
    fetch("includes/personsdata.php", {

    }) 
    .then(response => response.json())
    .then(data => {
        num_of_persons = data.length;
        console.log(data);
        //data row object keys: fname, lname, date_last_seen 

        for(let i=0; i<num_of_persons; i++){
            //each item in data array is an object with keys and values representing table data
            const currentRow = data[i];
            //get length of object (how many key-value pairs) 
            const rowLength = Object.keys(currentRow).length;

            const tableRow = document.createElement("tr");

            //iterate through currentRow object, adding the values as html elements to the DOM
            for(const [key, value] of Object.entries(currentRow)){

                const tableCell = document.createElement("td");
                const pTag = document.createElement("p");
                let text = document.createTextNode(value);
                pTag.appendChild(text);
                tableCell.appendChild(pTag);
                tableRow.appendChild(tableCell);
                
            }

            document.getElementById("persons-table").appendChild(tableRow);
            // const text = document.createTextNode("words"+i);
            // tableRow.appendChild(text);
        }
        console.log(data.length);
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