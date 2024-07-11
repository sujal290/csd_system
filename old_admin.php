<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "csd_system";

$conn = mysqli_connect($servername, $username, $password, $database);

$insert = false;
$delete = false;
$update = false;

if (!$conn) {
    die("Sorry, Connection with database is not built " . mysqli_connect_error());
}

// Handle form submission for adding new items
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $name = $_POST["name"];
    $category = $_POST["category"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stock_quantity = $_POST["stock_quantity"];

    $sql = "INSERT INTO `items` (`name`, `category`, `description`, `price`, `stock_quantity`, `date_&_time_added`) VALUES ('$name', '$category', '$description', '$price', '$stock_quantity', current_timestamp())";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $insert = true;
    } else {
        echo "The record was not inserted successfully because of this error --> " . mysqli_error($conn);
    }
}

// Handle form submission for deleting items
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $itemId = $_POST['itemId'];
    $sql = "DELETE FROM items WHERE itemId = $itemId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $delete = true;
    } else {
        echo "Error deleting item: " . mysqli_error($conn);
    }
}

// Handle form submission for updating items
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $itemId = $_POST['itemId'];
    $name = $_POST["name"];
    $category = $_POST["category"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stock_quantity = $_POST["stock_quantity"];

    $sql = "UPDATE items SET name='$name', category='$category', description='$description', price='$price', stock_quantity='$stock_quantity' WHERE itemId = $itemId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $update = true;
    } else {
        echo "Error updating item: " . mysqli_error($conn);
    }
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
    <title>Admin Dashboard</title>
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
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        th, td {
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

    <?php
    if ($insert) {
        echo "<div id='success-alert' class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>Success!</strong> Your record has been inserted successfully
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
              </button>
              </div>";
    }

    if ($delete) {
        echo "<div id='delete-alert' class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>Success!</strong> Item deleted successfully
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
              </button>
              </div>";
    }

    if ($update) {
        echo "<div id='update-alert' class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>Success!</strong> Item updated successfully
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
              </button>
              </div>";
    }
    ?>

    <div class="container">
        <div class="text-center my-4">
            <h2 class="font-weight-bold">Admin Dashboard</h2>
        </div>

        <div class="header-actions mb-3 mt-4 ">
            <h4>Available Items</h4>
            <div>
                <button id="add-btn" class="btn btn-primary"><i class="fas fa-plus"></i> Add</button>
                <button id="print-btn" class="btn btn-secondary"><i class="fas fa-print"></i> Print</button>
                < <button id="logout-btn" class="btn btn-danger" onclick="window.location.href='logout.php';"><i
                        class="fas fa-sign-out-alt"></i> Logout</button>
            </div>

        <div class="table-container">
            <table id="myTable">
                <thead >
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
                        echo "<tr>
                        <td class='text-center'>" . $sno . "</td>
                        <td class='text-center'>" . $row['itemId'] . "</td>
                        <td class='text-center'>" . $row['name'] . "</td>
                        <td class='text-center'>" . $row['category'] . "</td>
                        <td class='text-center'>" . $row['description'] . "</td>
                        <td class='text-center'>" . $row['price'] . "</td>
                        <td class='text-center'>" . $row['stock_quantity'] . "</td>
                        <td class='text-center'>" . $row['date_&_time_added'] . "</td>
                        <td class='d-flex flex-row mt-4 mb-[-1]'>
                            <button class='btn btn-outline-primary btn-sm mb-3' onclick='showUpdateModal(" . $row['itemId'] . ", \"" . $row['name'] . "\", \"" . $row['category'] . "\", \"" . $row['description'] . "\", " . $row['price'] . ", " . $row['stock_quantity'] . ")'><i class='fas fa-edit'></i> Update</button> <button class='btn-sm btn btn-outline-danger ml-2 mb-3' onclick='confirmDelete(" . $row['itemId'] . ")'><i class='fas fa-trash-alt'></i> Delete</button>
                        </td>
                    </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ADD Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add New Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" id="category" name="category" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="stock_quantity">Stock Quantity</label>
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <input type="hidden" id="updateItemId" name="itemId">
                        <div class="form-group">
                            <label for="updateName">Name</label>
                            <input type="text" class="form-control" id="updateName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="updateCategory">Category</label>
                            <input type="text" class="form-control" id="updateCategory" name="category" required>
                        </div>
                        <div class="form-group">
                            <label for="updateDescription">Description</label>
                            <input type="text" class="form-control" id="updateDescription" name="description" required>
                        </div>
                        <div class="form-group">
                            <label for="updatePrice">Price</label>
                            <input type="number" class="form-control" id="updatePrice" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="updateStockQuantity">Stock Quantity</label>
                            <input type="number" class="form-control" id="updateStockQuantity" name="stock_quantity" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <p>Are you sure you want to delete this item?</p>
                        <input type="hidden" id="itemIdToDelete" name="itemId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="jquery-3.3.1.slim.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="dataTables.dataTables.min.js"></script>
    <script>

        let table = new DataTable('#myTable');
        let itemIdToDelete = null;

        // Show modal on add button click
        document.getElementById('add-btn').addEventListener('click', function() {
            $('#addModal').modal('show');
        });

        function showUpdateModal(id, name, category, description, price, stock_quantity) {
            document.getElementById('updateItemId').value = id;
            document.getElementById('updateName').value = name;
            document.getElementById('updateCategory').value = category;
            document.getElementById('updateDescription').value = description;
            document.getElementById('updatePrice').value = price;
            document.getElementById('updateStockQuantity').value = stock_quantity;
            $('#updateModal').modal('show');
        }

        function confirmDelete(id) {
            document.getElementById('itemIdToDelete').value = id;
            $('#deleteModal').modal('show');
        }

        // Print button functionality
        document.getElementById('print-btn').addEventListener('click', function() {
            window.print();
        });

        
    </script>

</body>
</html>



<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "csd_system";

$conn = mysqli_connect($servername, $username, $password, $database);

$insert = false;
$delete = false;
$update = false;

if (!$conn) {
    die("Sorry, Connection with database is not built " . mysqli_connect_error());
}

// Handle form submission for adding new items
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $name = $_POST["name"];
    $category = $_POST["category"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stock_quantity = $_POST["stock_quantity"];

    $sql = "INSERT INTO `items` (`name`, `category`, `description`, `price`, `stock_quantity`, `date_&_time_added`) VALUES ('$name', '$category', '$description', '$price', '$stock_quantity', current_timestamp())";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $insert = true;
    } else {
        echo "The record was not inserted successfully because of this error --> " . mysqli_error($conn);
    }
}

// Handle form submission for deleting items
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $itemId = $_POST['itemId'];
    $sql = "DELETE FROM items WHERE itemId = $itemId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $delete = true;
    } else {
        echo "Error deleting item: " . mysqli_error($conn);
    }
}

// Handle form submission for updating items
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $itemId = $_POST['itemId'];
    $name = $_POST["name"];
    $category = $_POST["category"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stock_quantity = $_POST["stock_quantity"];

    $sql = "UPDATE items SET name='$name', category='$category', description='$description', price='$price', stock_quantity='$stock_quantity' WHERE itemId = $itemId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $update = true;
    } else {
        echo "Error updating item: " . mysqli_error($conn);
    }
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
    <title>Admin Dashboard</title>
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

    <?php
    if ($insert) {
        echo "<div id='success-alert' class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>Success!</strong> Your record has been inserted successfully
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
              </button>
              </div>";
    }

    if ($delete) {
        echo "<div id='delete-alert' class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>Success!</strong> Item deleted successfully
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
              </button>
              </div>";
    }

    if ($update) {
        echo "<div id='update-alert' class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>Success!</strong> Item updated successfully
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
              </button>
              </div>";
    }
    ?>

    <div class="container">
        <div class="text-center my-4">
            <h2 class="font-weight-bold">Admin Dashboard</h2>
        </div>

        <div class="header-actions mb-3 mt-4 ">
            <h4>Available Items</h4>
            <div>
                <button id="add-btn" class="btn btn-primary"><i class="fas fa-plus"></i> Add</button>
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
                        echo "<tr>
                        <td class='text-center'>" . $sno . "</td>
                        <td class='text-center'>" . $row['itemId'] . "</td>
                        <td class='text-center'>" . $row['name'] . "</td>
                        <td class='text-center'>" . $row['category'] . "</td>
                        <td class='text-center'>" . $row['description'] . "</td>
                        <td class='text-center'>" . $row['price'] . "</td>
                        <td class='text-center'>" . $row['stock_quantity'] . "</td>
                        <td class='text-center'>" . $row['date_&_time_added'] . "</td>
                        <td class='d-flex flex-row mt-4 mb-[-1]'>
                            <button class='btn btn-outline-primary btn-sm mb-3' onclick='showUpdateModal(" . $row['itemId'] . ", \"" . $row['name'] . "\", \"" . $row['category'] . "\", \"" . $row['description'] . "\", " . $row['price'] . ", " . $row['stock_quantity'] . ")'><i class='fas fa-edit'></i> Update</button> <button class='btn-sm btn btn-outline-danger ml-2 mb-3' onclick='confirmDelete(" . $row['itemId'] . ")'><i class='fas fa-trash-alt'></i> Delete</button>
                        </td>
                    </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ADD Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add New Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="admin_dashboard.php" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" id="category" name="category" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="stock_quantity">Stock Quantity</label>
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity"
                                required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Add Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- UPDATE Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="admin_dashboard.php" method="post">
                        <input type="hidden" id="updateItemId" name="itemId">
                        <div class="form-group">
                            <label for="updateName">Name</label>
                            <input type="text" class="form-control" id="updateName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="updateCategory">Category</label>
                            <input type="text" class="form-control" id="updateCategory" name="category" required>
                        </div>
                        <div class="form-group">
                            <label for="updateDescription">Description</label>
                            <textarea class="form-control" id="updateDescription" name="description" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="updatePrice">Price</label>
                            <input type="number" class="form-control" id="updatePrice" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="updateStockQuantity">Stock Quantity</label>
                            <input type="number" class="form-control" id="updateStockQuantity" name="stock_quantity"
                                required>
                        </div>
                        <button type="submit" name="update" class="btn btn-primary">Update Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this item?</p>
                    <form action="admin_dashboard.php" method="post">
                        <input type="hidden" id="deleteItemId" name="itemId">
                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="jquery-3.3.1.slim.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="dataTables.dataTables.min.js"></script>

    <!-- Page Script -->
    <script>
        // Logout function
        document.getElementById('logout-btn').addEventListener('click', function () {
            window.location.href = 'logout.php';
        });

        // DataTable initialization
        $(document).ready(function () {
            $('#myTable').DataTable();
        });

        // Show update modal with current values
        function showUpdateModal(itemId, name, category, description, price, stock_quantity) {
            document.getElementById('updateItemId').value = itemId;
            document.getElementById('updateName').value = name;
            document.getElementById('updateCategory').value = category;
            document.getElementById('updateDescription').value = description;
            document.getElementById('updatePrice').value = price;
            document.getElementById('updateStockQuantity').value = stock_quantity;
            $('#updateModal').modal('show');
        }

        // Show delete confirmation modal
        function confirmDelete(itemId) {
            document.getElementById('deleteItemId').value = itemId;
            $('#deleteModal').modal('show');
        }
         // Print button functionality
         document.getElementById('print-btn').addEventListener('click', function () {
            window.print();
        });
    </script>
</body>

</html>