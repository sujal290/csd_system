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
            /* background: #f5ffee; */
            color: #333;
            transition: background 0.5s ease-in-out;
        }

        .container {
            margin-top: 20px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .header-actions h2 {
            margin: 0;
            font-weight: bold;
            color: #333;
            transition: color 0.5s ease-in-out;
        }

        .table-container {
            overflow-x: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            /* background: #a0f2e3; */
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            color: #333;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            transition: background-color 0.3s ease-in-out;
        }

        th {
            /* background-color: #81c784; Light green for table headers */
            color: black;
        }

        td {
            background-color: #f5ffee; /* Very light green for table rows */
        }

        tr:nth-child(even) td {
            background-color: #a5d6a7; /* Slightly darker green for even rows */
        }

        tr:hover td {
            background-color: #66bb6a; /* Darker green for hovered rows */
        }

        @media (max-width: 900px) {
            .header-actions {
                flex-direction: column;
                align-items: flex-start;
            }

            .table-container {
                padding: 5px;
            }

            table, th, td {
                font-size: 0.9em;
            }
        }

        .btn {
            transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        #print-btn, #logout-btn {
            margin-left: 10px;
        }

        #add-btn {
            background-color: #ffcc80; /* Light orange button */
            border-color: #ffcc80;
        }

        #add-btn:hover {
            background-color: #ffb74d; /* Darker orange on hover */
        }

        #print-btn {
            background-color: #9575cd; /* Purple button */
            border-color: #9575cd;
        }

        #print-btn:hover {
            background-color: #7e57c2; /* Darker purple on hover */
        }

        #logout-btn {
            background-color: #ef5350; /* Red button */
            border-color: #ef5350;
        }

        #logout-btn:hover {
            background-color: #e53935; /* Darker red on hover */
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
                        <th class='text-center'>Select Quantity</th>
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
                                <td class='text-center'>
                                    <input type="number" name="selected_quantity" class='text-center' min="0" max="<?php echo $row['stock_quantity']; ?>" value="0">
                                </td>
                                <td>
                                    <input type="hidden" name="itemId" value="<?php echo $row['itemId']; ?>">
                                    <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                                    <input type="hidden" name="category" value="<?php echo $row['category']; ?>">
                                    <input type="hidden" name="description" value="<?php echo $row['description']; ?>">
                                    <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                                    <input type="hidden" name="stock_quantity" value="<?php echo $row['stock_quantity']; ?>">
                                    <button type="submit" name="Add_To_Cart" class='btn-sm btn btn-outline-primary'>Add To Cart</button>
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