//***************/
// Popup if FEMA materials needed are all 0
//***************/
const neededMaterialsQtys = document.getElementsByClassName("fema-materials-qty");
let numOfZeroes = 0;

for(let i=0; i<neededMaterialsQtys.length; i++){
    let curQuantity = parseInt(neededMaterialsQtys[i].children[0].innerHTML);
    
    if(curQuantity === 0) numOfZeroes++;
}

//display message if all quantity values are 0
if(numOfZeroes === neededMaterialsQtys.length) {
    document.getElementById("trucks-popup").style.display = "flex";
    document.getElementById("persons").style.marginBottom = "10%"; //add margin so message doesn't cover bottom of persons table/submit button
}


//****************/
// Submit Materials Needed Form
//****************/

// handle submitting of materials needed form
if(document.getElementById("materials-requested-form")){ //ensure form exists in DOM, as it will only appear for FEMA user
    document.getElementById("materials-requested-form").addEventListener('submit', event => {
        event.preventDefault();

        /*
            ensure that if a material quantity has been submitted, the respective material name checkbox has been checked,
            and vice versa (checkbox has been checked, must have a quantity selected)
        */
        const materialNames = document.getElementById("materials-requested-form").getElementsByClassName("chkbox");

        for(let i=0; i<materialNames.length; i++){
            let id = materialNames[i].id;
            if (materialNames[i].checked) {
                //all quantity boxes have the same id as the matching material name, with the additon of -qty
                // check if checked boxes have a value for their quantity
                if(document.getElementById(id+"-qty").value == "") {
                    alert("Please fill out form correctly");
                    window.location.reload();
                    return;
                }
            }
            else {
                // check if unchecked boxes have no value for their quantity
                if(document.getElementById(id+"-qty").value != "") {
                    alert("Please fill out form correctly");
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
}


//****************/
// Submit Materials Given Form
//****************/

//handle submitting of materials given form
if(document.getElementById("materials-given-form")){ //ensure form exists in DOM, depends on who is logged in 
    document.getElementById("materials-given-form").addEventListener('submit', event => {
        event.preventDefault();

        // ensure that a community center was selected, alert and do not submit otherwise
        const ccenterList = document.getElementById("cc-names-1");
        let optionChecked = false;
        for(let i=1; i<ccenterList.length; i++) {
            if(ccenterList[i].selected) {
                optionChecked = true;
            }
        }

        //alert if no center selected
        if(!optionChecked) {
            alert("Please Select a Community Center");
            return;
        }

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
                        alert("Please fill out form correctly");
                        window.location.reload();
                        return;
                    }
                }
                else {
                    // check if unchecked boxes have no value for their quantity
                    if(document.getElementById(id+"-qty").value != "") {
                        alert("Please fill out form correctly");
                        window.location.reload();
                        return;
                    }
                }
            }


        //serialize form data for sending as POST data
        let formData = new FormData(document.getElementById("materials-given-form"));

        //send form data to PHP file, and return response if successfully entered in DB or not
        fetch("./includes/mgivenformhandler.php", {
            method: 'POST',
            body: formData
        })
        //returning text, not json
        .then(response => response.text())
        .then(message => {

            //invalid data submitted (ex: caused quantity to be negative)
            if(message === "not_enough_resources"){
                alert("I said we don't have the capacity");
            }
            else if(message === "invalid"){
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
}

//****************/
// Submit Volunteers Needed Form
//****************/

// handle submitting of volunteers needed form
if(document.getElementById("rq-volunteers-form")){ //ensure form exists in DOM, as it will only appear for FEMA user
    document.getElementById("rq-volunteers-form").addEventListener('submit', event => {
        event.preventDefault();

        /*
            ensure that if a volunteer quantity has been submitted, the respective volunteer name checkbox has been checked,
            and vice versa (checkbox has been checked, must have a quantity selected)
        */
        const volunteersPositions = document.getElementById("rq-volunteers-form").getElementsByClassName("chkbox");

        for(let i=0; i<volunteersPositions.length; i++){
            let id = volunteersPositions[i].id;
            if (volunteersPositions[i].checked) {
                //all quantity boxes have the same id as the matching volunteer name, with the additon of -qty
                // check if checked boxes have a value for their quantity
                if(document.getElementById(id+"-qty").value == "") {
                    alert("Please fill out form correctly");
                    window.location.reload();
                    return;
                }
            }
            else {
                // check if unchecked boxes have no value for their quantity
                if(document.getElementById(id+"-qty").value != "") {
                    alert("Please fill out form correctly");
                    window.location.reload();
                    return;
                }
            }
        }
        //serialize form data for sending as POST data
        let formData = new FormData(document.getElementById("rq-volunteers-form"));

    //send form data to PHP file, and return response if successfully entered in DB or not
        fetch("includes/vneeded_formhandler.php", {
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
}

//****************/
// Handle submitting of donate to ccenter form
//****************/

if(document.getElementById("ccenter-donate-form")){ //ensure form exists in DOM
    document.getElementById("ccenter-donate-form").addEventListener('submit', event => {
        event.preventDefault();

        // ensure that a community center was selected, alert and do not submit otherwise
        const ccenterList = document.getElementById("cc-names-2");
        let optionChecked = false;
        for(let i=1; i<ccenterList.length; i++) {
            if(ccenterList[i].selected) {
                optionChecked = true;
            }
        }

        //alert if no center selected
        if(!optionChecked) {
            alert("Please Select a Community Center");
            return;
        }
        /*
            ensure that if a material quantity has been submitted, the respective material name checkbox has been checked,
            and vice versa (checlbox has been checked, must have a quantity selected)
        */
        const materialNames = document.getElementById("ccenter-donate-form").getElementsByClassName("chkbox");

        for(let i=0; i<materialNames.length; i++){
            let id = materialNames[i].id;
            if (materialNames[i].checked) {
                //all quantity boxes have the same id as the matching material name, with the additon of -qty
                // check if checked boxes have a value for their quantity
                if(document.getElementById(id+"-qty").value == "") {
                    alert("Please fill out form correctly");
                    window.location.reload();
                    return;
                }
            }
            else {
                // check if unchecked boxes have no value for their quantity
                if(document.getElementById(id+"-qty").value != "") {
                    alert("Please fill out form correctly");
                    window.location.reload();
                    return;
                }
            }
        }
        //serialize form data for sending as POST data
        let formData = new FormData(document.getElementById("ccenter-donate-form"));

    //send form data to PHP file, and return response if successfully entered in DB or not
        fetch("includes/ccenter_donate_formhandler.php", {
            method: 'POST',
            body: formData
        })
        //returning text, not json
        .then(response => response.text())
        .then(message => {

            if(message === "no center chosen") {
                // console.log('y');
                alert("Please Select a Community Center");
                window.location.reload();
                return;
            }
            console.log(message);
            window.location.reload();

        })
        .catch(error => {
            console.log(error);
            // alert(error);
        })

    });
}

//******************/
// Remove missing person using checkbox
//******************/

//checkboxes for each missing person in table
let foundChboxes = document.getElementsByClassName("found-chbox");

//when a given checkbox is selected, remove the entry from the db and reload the page
for(let i=0; i<foundChboxes.length; i++) {
    foundChboxes[i].addEventListener('click', function(e) {
        const tableRow = this.parentElement.parentElement;
        
        // alert(tableRow);
        // tableRow.style.display = "none";
        
        const childCells = tableRow.children;
        const NUM_OF_FIELDS = 3; //there are 3 fields in the missing persons table: fname, lname, date last seen
        
        //object with person fields, data to be sent to PHP for db query
        const personFields = {
            fname: childCells[0].firstChild.innerHTML,
            lname: childCells[1].firstChild.innerHTML,
            date_seen: childCells[2].firstChild.innerHTML
        };
        
        //allow user to cancel remove request
        if(confirm(`Are you sure you want to mark ${personFields.fname} ${personFields.lname} as found?`)){
            console.log(personFields);
            
            //send data to PHP file
            fetch("includes/delete_person.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: JSON.stringify({personFields})
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
            });
        }
        else {
            this.checked = false;
        }
    });
}
//****************/
// Add Missing Persons Modal
//****************/

//display or hide modal
function toggleMissingModal(){
    const modal = document.getElementById("missing-modal");
    if(getComputedStyle(modal).display == 'none'){
        modal.style.display = "flex";
    }
    else {
        modal.style.display = "none";
    }
}



// TODO

// IDEAS
//  - check that material name from db matches name in table for respective quantity? ensures things aren't put in the wrong spot instead of just relying on order