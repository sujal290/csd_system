<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "csd_system";

session_start();

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Sorry, Connection with database is not built " . mysqli_connect_error());
}

$updateSuccess = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['Add_To_Cart'])) {
        if (isset($_SESSION['cart'])) {
            $item_array_id = array_column($_SESSION['cart'], "itemId");
            if (in_array($_POST['itemId'], $item_array_id)) {
                echo "<script>alert('Item is already added in the cart!')</script>";
                echo "<script>window.location = 'cartpage.php'</script>";
            } else {
                $count = count($_SESSION['cart']);
                $_SESSION['cart'][$count] = array(
                    'itemId' => $_POST['itemId'],
                    'name' => $_POST['name'],
                    'category' => $_POST['category'],
                    'description' => $_POST['description'],
                    'price' => $_POST['price'],
                    'selected_quantity' => $_POST['selected_quantity']
                );

                echo "<script>alert('Item is Successfully added in the cart!')</script>";
                echo "<script>window.location = 'cartpage.php'</script>";
            }
        } else {
            $_SESSION['cart'][0] = array(
                'itemId' => $_POST['itemId'],
                'name' => $_POST['name'],
                'category' => $_POST['category'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'selected_quantity' => $_POST['selected_quantity']
            );

            echo "<script>alert('Item is Successfully added in the cart!')</script>";
            echo "<script>window.location = 'cartpage.php'</script>";
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

    if (isset($_POST['Update_Item'])) {
        $editItemId = $_POST['editItemId'];
        $newQuantity = $_POST['selected_quantity'];

        // Fetch stock_quantity from your database
        $query = "SELECT stock_quantity FROM items WHERE itemId = " . $editItemId;
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Error fetching stock quantity: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $stockQuantity = $row['stock_quantity'];

            // Ensure the new quantity does not exceed stock quantity
            if ($newQuantity > $stockQuantity) {
                $newQuantity = $stockQuantity;
                echo "<script>alert('Selected quantity exceeds available stock. Updated to maximum available.')</script>";
            }

            // Update session cart with new quantity
            foreach ($_SESSION['cart'] as $key => $value) {
                if ($value['itemId'] == $editItemId) {
                    $_SESSION['cart'][$key]['selected_quantity'] = $newQuantity;
                    $updateSuccess = true; // Set update success flag
                    break;
                }
            }
        } else {
            die("Item with ID " . $editItemId . " not found in database.");
        }

        // Redirect back to cart page after update
        header("Location: cartpage.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="dataTables.dataTables.min.css">
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
                        <th class='text-center'>Selected Quantity</th>
                        <th class='text-center'>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    $total = 0;
                    if (isset($_SESSION['cart'])) {
                        $sno = 0;
                        foreach ($_SESSION['cart'] as $key => $value) {
                            // Fetch stock_quantity from your database
                            $query = "SELECT stock_quantity FROM items WHERE itemId = " . $value['itemId'];
                            $result = mysqli_query($conn, $query);
                            if (!$result) {
                                die("Error fetching stock quantity: " . mysqli_error($conn));
                            }
                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $stockQuantity = $row['stock_quantity'];
                            }

                            // Calculate total price
                            $total += $value['price'] * $value['selected_quantity'];
                            $sno++;
                            echo "<tr>";
                            echo "<td class='text-center'>" . $sno . "</td>";
                            echo "<td class='text-center'>" . $value['itemId'] . "</td>";
                            echo "<td class='text-center'>" . $value['name'] . "</td>";
                            echo "<td class='text-center'>" . $value['category'] . "</td>";
                            echo "<td class='text-center'>" . $value['description'] . "</td>";
                            echo "<td class='text-center'>" . $value['price'] . "</td>";
                            echo "<td class='text-center'>" . $value['selected_quantity'] . "</td>";
                            echo "<td>
                                    <button class='btn btn-outline-primary btn-sm edit-btn' 
                                            data-itemid='" . $value['itemId'] . "' 
                                            data-selectedquantity='" . $value['selected_quantity'] . "' 
                                            data-stockquantity='" . $stockQuantity . "'>Edit</button>
                                    <form action='cartpage.php' method='POST' style='display:inline-block;'>
                                        <button name='Remove_Item' class='btn btn-outline-danger btn-sm'>Remove</button>
                                        <input type='hidden' name='itemId' value='" . $value['itemId'] . "'>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Your cart is empty</td></tr>";
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

    <!-- Edit Modal -->
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Quantity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="cartpage.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editQuantity">Selected Quantity:</label>
                            <input type="number" class="form-control" id="editQuantity" name="selected_quantity" value="" min="1" max="10">
                            <input type="hidden" name="editItemId" id="editItemId" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="Update_Item">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="jquery-3.3.1.slim.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <!-- DataTables JS -->
    <script src="dataTables.min.js"></script>

    <!-- JavaScript for displaying success alert -->
    <script>
        $(document).ready(function() {
            <?php if ($updateSuccess): ?>
                // Display success alert using Bootstrap alert
                $('.container').prepend('<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">Item quantity updated successfully!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            <?php endif; ?>
            
            $('.edit-btn').on('click', function() {
                var itemId = $(this).data('itemid');
                var selectedQuantity = $(this).data('selectedquantity');
                var stockQuantity = $(this).data('stockquantity');

                $('#editItemId').val(itemId);
                $('#editQuantity').attr('max', stockQuantity); // Set max attribute dynamically
                $('#editQuantity').val(selectedQuantity);
                $('#editModal').modal('show');
            });

            let table = $('#myTable').DataTable();
        });
    </script>

</body>
</html>