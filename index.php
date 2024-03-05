<?php
    define('_BASEPAGE', 1);
    
?>

<!-- TODO: dont allow user to submit a quantity without checking the respective checkbox -->

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
    
    <h1 style="text-align: center; margin-top: 1em;">FEMA</h1>

    <!-- form for requesting materials -->
    <div id="material-forms">
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

        <!-- form for "giving" materials -->
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
    </div>

    <!-- ************ Does this really need to be a form? *********** -->
    <form action="" class="forms" id="materials-needed-form">
        <h2>Current Items Needed</h2>
        <table>
            <tr>
                <td>Mens Clothes</td>
                <td class="qty-needed"></td>
            </tr>
            <tr>
                <td>Womens Clothes</td>
                <td class="qty-needed"></td>
            </tr>
            <tr>
                <td>Teens Clothes</td>
                <td class="qty-needed"></td>
            </tr>
            <tr>
                <td>Toddlers Clothes</td>
                <td class="qty-needed"></td>
            </tr>
        </table>
    </form>

    <div id="persons">
        <h2>Missing Persons</h2>
        <table id="persons-table">
        </table>
    </div>
    <script src="functions.js"></script>
</body>
</html>