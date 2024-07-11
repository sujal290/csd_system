<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "csd_system y";

session_start();

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Sorry, Connection with database is not built " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['Add_To_Cart'])) {
        if (isset($_SESSION['cart'])) {
            $item_array_id = array_column($_SESSION['cart'], "itemId");
            if (in_array($_POST['itemId'], $item_array_id)) {
                echo "<script>alert('Item is already added in the cart!')</script>";
                echo "<script>window.location = 'user_dashboard.php'</script>";
            } else {
                $count = count($_SESSION['cart']);
                $_SESSION['cart'][$count] = array(
                    'itemId' => $_POST['itemId'],
                    'name' => $_POST['name'],
                    'category' => $_POST['category'],
                    'description' => $_POST['description'],
                    'price' => $_POST['price'],
                    'stock_quantity' => $_POST['stock_quantity'],
                    'Quantity' => 1
                );

                echo "<script>alert('Item is Successfully added in the cart!')</script>";
                echo "<script>window.location = 'user_dashboard.php'</script>";
            }
        } else {
            $_SESSION['cart'][0] = array(
                'itemId' => $_POST['itemId'],
                'name' => $_POST['name'],
                'category' => $_POST['category'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'stock_quantity' => $_POST['stock_quantity'],
                'Quantity' => 1
            );

            echo "<script>alert('Item is Successfully added in the cart!')</script>";
            echo "<script>window.location = 'user_dashboard.php'</script>";
        }
    }

    if (isset($_POST['Remove_Item'])) {
        foreach ($_SESSION['cart'] as $key => $value) {
            if ($value['itemId'] == $_POST['itemId']) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                echo "<script>alert('Item is Successfully Removed from the cart!')</script>";
                echo "<script>window.location = 'cartpage.php'</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min1.css">
    <link href="css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dataTables.dataTables.min.css">

    <title>Cart Page</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        h1 {
            margin-top: 20px;
        }

        .cart-table {
            margin-top: 30px;
        }

        .cart-table th,
        .cart-table td {
            vertical-align: middle;
        }

        .cart-summary {
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .cart-summary {
                margin-top: 20px;
            }
        }
    </style>
</head>

<body>

    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container">
        
        <div class="d-flex justify-content-between mt-4">
            <h1>My Cart</h1>
            <button onclick="window.print()" class="btn btn-info mb-2 mt-3 font-weight-bold">Take-Print</button>
        </div>


        <div class="table-responsive cart-table">
            <table id="myTable" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th class='text-center'>SNo.</th>
                        <th class='text-center'>Item ID</th>
                        <th class='text-center'>Name</th>
                        <th class='text-center'>Category</th>
                        <th class='text-center'>Description</th>
                        <th class='text-center'>Price</th>
                        <th class='text-center'>Stock Quantity</th>
                        <th class='text-center'>Quantity</th>
                        <th class='text-center'>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    $total = 0;
                    if (isset($_SESSION['cart'])) {
                        $sno = 0;
                        foreach ($_SESSION['cart'] as $key => $value) {
                            $total += $value['price'];
                            $sno++;
                            echo "<tr>";
                            echo "<td class='text-center'>" . $sno . "</td>";
                            echo "<td class='text-center'>" . $value['itemId'] . "</td>";
                            echo "<td class='text-center'>" . $value['name'] . "</td>";
                            echo "<td class='text-center'>" . $value['category'] . "</td>";
                            echo "<td class='text-center'>" . $value['description'] . "</td>";
                            echo "<td class='text-center'>" . $value['price'] . "</td>";
                            echo "<td class='text-center'>" . $value['stock_quantity'] . "</td>";
                            echo "<td>" . "<input class='text-center form-control' type='number' value='" . $value['Quantity'] . "' min='1' max='10'>" . "</td>";
                            echo "<td>
                                    <form action='cartpage.php' method='POST'>
                                        <button name='Remove_Item' class='btn btn-outline-danger btn-sm'>Remove</button>
                                        <input type='hidden' name='itemId' value='" . $value['itemId'] . "'>
                                    </form>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>Your cart is empty</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="col-lg-3 col-md-6 ml-auto cart-summary">
            <div class="border bg-light rounded p-4">
                <h3>Total:</h3>
                <h5 class='text-right'><?php echo $total ?></h5>
                <br>
                <form>
                    <!-- radio button -->
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="onlinePayment">
                        <label class="form-check-label" for="onlinePayment">
                            Online Payment
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="codPayment" checked>
                        <label class="form-check-label" for="codPayment">
                            Cash On Delivery
                        </label>
                    </div>
                    <br>
                    <button class="btn btn-primary btn-block">Make Purchase</button>
                </form>
            </div>
        </div>


    </div>

    <!-- Optional JavaScript -->
    <script src="jquery-3.3.1.slim.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="dataTables.min.js"></script>

    <script>
        let table = new DataTable('#myTable');
    </script>
</body>

</html>
