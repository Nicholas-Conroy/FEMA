<!-- TODO: dont allow user to submit a quantity without checking the respective checkbox -->

<?php
    require_once "includes/data.php";
    require_once "includes/config_session.inc.php";

    //if user is not logged in and tries to access page, they are returned to login page
    if(!isset($_SESSION["user_id"])) { //set on login.inc.php
        header("Location: ./index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>FEMA</title>
</head>
<body>

    <form action="includes/logout.inc.php" method="post">
        <button>Logout</button>
    </form>
    <?php 
        echo 'You are logged in as ' . $_SESSION["user_username"];
    ?>

    <h1 style="text-align: center; margin-top: 1em;">FEMA</h1>
    
    <div id="material-forms">
    <?php 
        if($_SESSION["user_username"] === "fema"){ ?>
        <!-- form for requesting materials -->
        <form action="./includes/mneededformhandler.php" id="materials-requested-form" method="post" class="forms">
            <h2>Materials Needed</h2>
        
            <table>
                <tr>
                    <td>
                        <label for="rq-mens">Mens</label>
                        <input type="checkbox" name="rq-mens" id="rq-mens" class="chkbox" value="Mens">
                    </td>
                    <td>
                        <label for="rq-mens-qty">Quantity</label>
                        <input type="number" class="quantity-input" min="0" name="rq-mens-qty" id="rq-mens-qty">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="rq-womens">Womens</label>
                        <input type="checkbox" name="rq-womens" id="rq-womens" class="chkbox" value="Womens">
                    </td>
                    <td>
                        <label for="rq-womens-qty">Quantity</label>
                        <input type="number" class="quantity-input" min="0" name="rq-womens-qty" id="rq-womens-qty">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="rq-teens">Teens</label>
                        <input type="checkbox" name="rq-teens" id="rq-teens" class="chkbox" value="Teens">
                    </td>
                    <td>
                        <label for="rq-teens-qty">Quantity</label>
                        <input type="number" class="quantity-input" min="0" name="rq-teens-qty" id="rq-teens-qty">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="rq-toddlers">Toddlers</label>
                        <input type="checkbox" name="rq-toddlers" id="rq-toddlers" class="chkbox" value="Toddlers">
                    </td>
                    <td>
                        <label for="rq-toddlers-qty">Quantity</label>
                        <input type="number" class="quantity-input" min="0" name="rq-toddlers-qty" id="rq-toddlers-qty">
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><button type="submit">Submit</button></td>
                </tr>
            </table>
        </form>
        <?php } ?>

        <!-- form for "giving" materials to fema -->
        <?php 
            if(!$_SESSION["user_username"] === "fema"){ ?>
         <form action="./includes/mgivenformhandler.php" id="materials-given-form" method="post" class="forms">
            <h2>Materials to Give</h2>
        
            <table>
            <tr>
                    <td>
                        <label for="gv-mens">Mens</label>
                        <input type="checkbox" name="gv-mens" id="gv-mens" class="chkbox" value="Mens">
                    </td>
                    <td>
                        <label for="gv-mens-qty">Quantity</label>
                        <input type="number" class="quantity-input" min="0" name="gv-mens-qty" id="gv-mens-qty">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="gv-womens">Womens</label>
                        <input type="checkbox" name="gv-womens" id="gv-womens" class="chkbox" value="Womens">
                    </td>
                    <td>
                        <label for="gv-womens-qty">Quantity</label>
                        <input type="number" class="quantity-input" min="0" name="gv-womens-qty" id="gv-womens-qty">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="gv-teens">Teens</label>
                        <input type="checkbox" name="gv-teens" id="gv-teens" class="chkbox" value="Teens">
                    </td>
                    <td>
                        <label for="gv-teens-qty">Quantity</label>
                        <input type="number" class="quantity-input" min="0" name="gv-teens-qty" id="gv-teens-qty">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="gv-toddlers">Toddlers</label>
                        <input type="checkbox" name="gv-toddlers" id="gv-toddlers" class="chkbox" value="Toddlers">
                    </td>
                    <td>
                        <label for="gv-toddlers-qty">Quantity</label>
                        <input type="number" class="quantity-input" min="0" name="gv-toddlers-qty" id="gv-toddlers-qty">
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><button type="submit" id="m-given-submit">Submit</button></td>
                </tr>
            </table>
        </form>
        <?php } ?>
    </div>
    <br><br>

    <!-- community center materials -->
    <div id="comm-center-info">
        <h2>Community Centers</h2>
        <table>
            <tr>
                <th>Center Name</th>
                <th>Men's Clothing Available</th>
                <th>Women's Clothing Available</th>
                <th>Teens' Clothing Available</th>
                <th>Toddlers' Clothing Available</th>
            </tr>
            <?php
                get_comm_center_data(); 
            ?>
        </table>
    </div>

    <br><br>
  
    <!-- materials needed by fema table -->
    <div id="materials-needed-table">
        <table>
            <h2>Materials Needed by FEMA</h2>
            <tr>
                <th>Material Type</th>
                <th>Quantity Needed</th>
            </tr>
            <?php
               get_materials_needed();
            ?>
        </table>
    </div>

    <div id="persons">
        <h2>Missing Persons</h2>
        <table id="persons-table">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date Last Seen</th>
                <?php if($_SESSION["user_username"] === "fema"){
                    echo '<th>Mark as Found</th>';
                }
                ?>
            </tr>
            <?php   
                get_missing_persons();
            ?>
        </table>
       
        <?php
        //only display this if user is logged in as fema
            if($_SESSION["user_username"] === "fema"){ ?>
                    <div id="update-missing">
                        <button id="add-missing-btn" type="button" onclick="toggleMissingModal()">Add Missing Person</button>
                    </div>
                
           <?php } ?>
    </div>

    <?php
    //only display this if user is logged in as fema
        if($_SESSION["user_username"] === "fema"){ ?>
                <div class="modal" id="missing-modal">
                    <!-- <div class="x-btn-container">
                        <button class="x-btn">X</button>
                    </div> -->
                    <form action="./includes/mpersonformhandler.php" class="forms" id="missing-form" method="post">
                        <h4>Enter Information</h4>
                        <div>
                            <label for="fname">First Name</label>
                            <input type="text" id="fname" name="fname">
                        </div>
                        <div>
                            <label for="lname">Last Name</label>
                            <input type="text" name="lname" id="lname">
                        </div>
                        <div>
                            <label for="date-seen">Date Last Seen</label>
                            <input type="date" name="date-seen" id="date-seen">
                        </div>
                        <button type="submit" name="missing-submit" id="missing-submit">Submit</button>
                    </form>
                </div>  
      <?php  } ?>



    <script src="functions.js"></script>
</body>
</html>