<?php
    define('_BASEPAGE', 1);
    
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
    
    <h1 style="text-align: center; margin-top: 1em;">FEMA</h1>

    <form action="./includes/mformhandler.php" id="materials-form" method="post" class="forms">
        <h2>Materials Needed</h2>
        
        <table>
            <tr>
                <td>
                    <label for="poutine">Poutine</label>
                    <input type="checkbox" name="poutine" value="Poutine">
                </td>
                <td>
                    <label for="poutine-qty">Quantity</label>
                    <input type="number" class="quantity-input" min="0" name="poutine-qty">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Item 2</label>
                    <input type="checkbox">
                </td>
                <td>
                    <label for="">Quantity</label>
                    <input type="number" class="quantity-input" min="0">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Item 2</label>
                    <input type="checkbox">
                </td>
                <td>
                    <label for="">Quantity</label>
                    <input type="number" class="quantity-input" min="0">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Item 4</label>
                    <input type="checkbox">
                </td>
                <td>
                    <label for="">Quantity</label>
                    <input type="number" class="quantity-input" min="0">
                </td>
            </tr>
            <tr>
                <td colspan="2"><button type="submit">Submit</button></td>
            </tr>
        </table>
    </form>

    <form action="" class="forms" id="materials-needed-form">
        <h2>Current Items Needed</h2>
        <table>
            <tr>
                <td>Poutine Needed</td>
                <td class="qty-needed"></td>
            </tr>
            <tr>
                <td>Item 2 Needed</td>
                <td class="qty-needed"></td>
            </tr>
            <tr>
                <td>Item 3 Needed</td>
                <td class="qty-needed"></td>
            </tr>
            <tr>
                <td>Item 4 Needed</td>
                <td class="qty-needed"></td>
            </tr>
        </table>
    </form>

    <script src="functions.js"></script>
</body>
</html>