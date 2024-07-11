<?php
session_start();

$error_message = '';

if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Database connection
    $conn = new mysqli("localhost", "root", "", "csd_system");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL query with JOIN to fetch fullname from id_group
    $query = "SELECT e.id, e.password, e.desig_id, e.group_id, e.first_name, e.middle_name, e.last_name, e.is_created, d.desig_fullname, g.fullname AS group_fullname
              FROM id_emp e
              INNER JOIN id_desig d ON e.desig_id = d.id
              INNER JOIN id_group g ON e.group_id = g.group_id
              WHERE e.username = '$username' AND e.user_type = 'Employee'";
    
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if ($password === $row['password']) {
            // Store session data
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['desig_id'] = $row['desig_id'];
            $_SESSION['group_id'] = $row['group_id'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['middle_name'] = $row['middle_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['is_created'] = $row['is_created'];
            $_SESSION['desig_fullname'] = $row['desig_fullname'];
            $_SESSION['group_fullname'] = $row['group_fullname'];

            // Redirect to dashboard
            header('Location: dashboard.php');
            exit;
        } else {
            $error_message = "Incorrect password.";
        }
    } else {
        $error_message = "User not found or incorrect Credentials";
    }

    $conn->close();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="bootstrap.min1.css">
    <link rel="stylesheet" href="all.min.css">
    <link rel="stylesheet" href="dataTables.dataTables.min.css">
    <title>User Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .container {
            margin-top: 20px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .header-actions h2 {
            margin: 0;
            font-weight: bold;
        }

        .table-container {
            overflow-x: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: white;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        @media (max-width: 900px) {
            .header-actions {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="text-center my-4">
            <h2 class="font-weight-bold">User Dashboard</h2>
        </div>
        <div class="header-actions">
            <h2>Available Items</h2>
            <div>
                <?php
                $count = 0;
                if (isset($_SESSION['cart'])) {
                    $count = count($_SESSION['cart']);
                }
                ?>
                <button id="add-btn" class="btn btn-primary" onclick="window.location.href='cartpage.php';"><i
                        class="fa-solid fa-cart-plus"></i> My Cart : <?php echo $count; ?> </button>
                <button id="print-btn" class="btn btn-secondary"><i class="fas fa-print"></i> Print</button>
                <button id="logout-btn" class="btn btn-danger" onclick="window.location.href='logout.php';"><i
                        class="fas fa-sign-out-alt"></i> Logout</button>
            </div>
        </div>

        <div class="table-container">
            <table id="myTable">
                <thead>
                    <tr>
                        <th class='text-center'>SNo.</th>
                        <th class='text-center'>Item ID</th>
                        <th class='text-center'>Name</th>
                        <th class='text-center'>Category</th>
                        <th class='text-center'>Description</th>
                        <th class='text-center'>Price</th>
                        <th class='text-center'>Stock Quantity</th>
                        <th class='text-center'>Date & Time</th>
                        <th class='text-center'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM items";
                    $result = mysqli_query($conn, $sql);

                    $sno = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sno = $sno + 1;
                        ?>
                        <tr>
                            <form action="cartpage.php" method="POST">
                                <td class='text-center'><?php echo $sno; ?></td>
                                <td class='text-center'><?php echo $row['itemId']; ?></td>
                                <td class='text-center'><?php echo $row['name']; ?></td>
                                <td class='text-center'><?php echo $row['category']; ?></td>
                                <td class='text-center'><?php echo $row['description']; ?></td>
                                <td class='text-center'><?php echo $row['price']; ?></td>
                                <td class='text-center'><?php echo $row['stock_quantity']; ?></td>
                                <td class='text-center'><?php echo $row['date_&_time_added']; ?></td>
                                <td>
                                    <input type="hidden" name="itemId" value="<?php echo $row['itemId']; ?>">
                                    <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                                    <input type="hidden" name="category" value="<?php echo $row['category']; ?>">
                                    <input type="hidden" name="description" value="<?php echo $row['description']; ?>">
                                    <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                                    <input type="hidden" name="stock_quantity"
                                        value="<?php echo $row['stock_quantity']; ?>">
                                    <button type="submit" name="Add_To_Cart" class='btn-sm btn btn-outline-primary'>Add To
                                        Cart</button>
                                </td>
                            </form>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="jquery-3.3.1.slim.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min1.js"></script>
    <script src="dataTables.min.js"></script>

    <script>
        let table = new DataTable('#myTable');
        let itemIdToDelete = null;
        // Print button functionality
        document.getElementById('print-btn').addEventListener('click', function () {
            window.print();
        });
    </script>

</body>

</html>