<!-- TODO: dont allow user to submit a quantity without checking the respective checkbox -->

<?php
    require_once "includes/data.php";
    require_once "includes/config_session.inc.php";

    error_reporting(E_ALL); 
    ini_set('display_errors', 1);
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
    <link rel="stylesheet" href="styles/home_styles.css">
    <title>FEMA</title>
</head>
<body>

    <header>
        <hr class="header-line">
        <div id="login-info">
            <?php
                echo '<p>Welcome ' . $_SESSION["user_username"] . '!</p>';
                // use output_username function instead?
            ?>
            <form action="includes/logout.inc.php" method="post">
                <button class="form-submit-btn" id="logout-btn">Logout</button>
            </form>
        </div>
        <h1>FEMA</h1>
        <hr class="header-line">
    </header>


    <!-- ********************** -->
    <!-- data tables -->
    <!-- ********************** -->
    <section id="material-data-tables">
        
        <!-- table for displaying FEMA needed materials -->
        <div id="materials-needed-container">
            <table id="fema-materials-table">
                <div class="table-header">
                    <h2>Materials Needed by FEMA</h2>
                </div>
                <tr>
                    <th><p>Material Type</p></th>
                    <th><p>Quantity Needed</p></th>
                </tr>
                <?php
                    get_materials_needed();
                ?>
            </table>
        </div>

            <!-- table for displaying FEMA needed volunteers -->
            <div id="volunteers-needed-container">
            <table id="volunteers-needed-table">
                <div class="table-header">
                    <h2>Volunteers Needed by FEMA</h2>
                </div>
                <tr>
                    <th><p>Volunteer Type</p></th>
                    <th><p>Amount Needed</p></th>
                </tr>
                <?php
                    get_volunteers_info();
                ?>
            </table>
        </div>
    
        
        <!-- community center materials -->
        <div id="comm-center-info">
            <div class="table-header">
                <h2>Community Centers</h2>
            </div>
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
    </section>

    <!-- ********************** -->
    <!-- donation/request forms -->
    <!-- ********************** -->
    <section id="donate-request-forms">

        <!-- form for fema requesting materials -->
        <?php 
            if($_SESSION["user_username"] === "fema"){ ?>
        <div id="rq-materials-container">
            <form action="./includes/formhandlers/mneededformhandler.php" id="materials-requested-form" method="post" class="forms">     
                <div class="table-header">
                    <h2>Add Materials Needed</h2>
                </div>
            
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
                </table>
                <button type="submit" class="form-submit-btn">Submit</button>
            </form>
        </div>
        <?php } ?>

        <!-- form for fema requesting volunteers -->
        <?php 
            if($_SESSION["user_username"] === "fema"){ ?>
        <div id="rq-volunteers-container">
            <form action="includes/formhandlers/vneeded_formhandler.php" id="rq-volunteers-form" method="post" class="forms">     
                <div class="table-header">
                    <h2>Add Volunteers Needed</h2>
                </div>
            
                <table>
                    <?php
                        get_volunteers_names();
                    ?>
                </table>
                <button type="submit" class="form-submit-btn">Submit</button>
            </form>
        </div>
        <?php } ?>
            
        <div>
            <!-- form for "giving" materials to fema -->
            <?php
                if($_SESSION["user_username"] !== "fema"){ ?>
            <form action="./includes/formhandlers/mgivenformhandler.php" id="materials-given-form" method="post" class="forms">
                <div class="table-header">
                    <h2>Materials to Give to FEMA</h2>
                </div>
            
                <table>
                    <tr>
                        <td colspan="2">
                            <label for="cc-names">Choose Center to Donate From: </label>
                            <select name="cc-names" id="cc-names">
                                <?php
                            get_comm_center_names();
                                ?>
                            </select>
                        </td>
                    </tr>
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
                </table>
                <button type="submit" id="m-given-submit" class="form-submit-btn">Submit</button>
            </form>
            <?php } ?>
        </div>
        
        <!-- form to volunteer for a position -->
        <div>
            <h2>Where can you help out?</h2>
            <form action="">
                <select name="volunteer-list" id="volunteer-list">
                    <?php
                        get_volunteers_list();
                    ?>
                </select>
                <div>
                    <button>Volunteer!</button>
                </div>
            </form>
        </div>

        <!-- form to donate to community center -->
        <div>
            <?php
                    if($_SESSION["user_username"] !== "fema"){ ?>
            <form action="./includes/formhandlers/ccenter_donate_formhandler.php" id="ccenter-donate-form" method="post" class="forms">
                    <div class="table-header">
                        <h2>Donate to Community Center</h2>
                    </div>
                    <table>
                        <tr>
                            <td colspan="2">
                                <label for="cc-names">Donate to:</label>
                                <select name="cc-names" id="cc-names">
                                    <?php
                                get_comm_center_names();
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="cc-mens">Mens</label>
                                <input type="checkbox" name="cc-mens" id="cc-mens" class="chkbox" value="Mens">
                            </td>
                            <td>
                                <label for="cc-mens-qty">Quantity</label>
                                <input type="number" class="quantity-input" min="0" name="cc-mens-qty" id="cc-mens-qty">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="cc-womens">Womens</label>
                                <input type="checkbox" name="cc-womens" id="cc-womens" class="chkbox" value="Womens">
                            </td>
                            <td>
                                <label for="cc-womens-qty">Quantity</label>
                                <input type="number" class="quantity-input" min="0" name="cc-womens-qty" id="cc-womens-qty">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="cc-teens">Teens</label>
                                <input type="checkbox" name="cc-teens" id="cc-teens" class="chkbox" value="Teens">
                            </td>
                            <td>
                                <label for="cc-teens-qty">Quantity</label>
                                <input type="number" class="quantity-input" min="0" name="cc-teens-qty" id="cc-teens-qty">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="cc-toddlers">Toddlers</label>
                                <input type="checkbox" name="cc-toddlers" id="cc-toddlers" class="chkbox" value="Toddlers">
                            </td>
                            <td>
                                <label for="cc-toddlers-qty">Quantity</label>
                                <input type="number" class="quantity-input" min="0" name="cc-toddlers-qty" id="cc-toddlers-qty">
                            </td>
                        </tr>
                        </table>
                        <button type="submit" id="m-given-submit" class="form-submit-btn">Submit</button>
                </form>
                <?php } ?>
        </div>
        
    </section>


    <!-- ********************** -->
    <!-- missing persons -->
    <!-- ********************** -->

    <section id="missing-persons">
        <div id="persons">
            <div class="table-header">
                <h2>Missing Persons</h2>
            </div>
            <table id="persons-table">
                <tr>
                    <th><p>First Name</p></th>
                    <th><p>Last Name</p></th>
                    <th><p>Date Last Seen</p></th>
                    <?php if($_SESSION["user_username"] === "fema"){
                        echo '<th><p>Mark as Found</p></th>';
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
                            <button id="add-missing-btn" type="button" onclick="toggleMissingModal()" class="form-submit-btn">Add Missing Person</button>
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
                        <form action="./includes/formhandlers/mpersonformhandler.php" class="forms" id="missing-form" method="post">
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
    </section>

    <script src="functions.js"></script>
</body>
</html>