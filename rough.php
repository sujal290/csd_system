<?php
session_start();

$error_message = '';

if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Database connection
    $conn = new mysqli("localhost", "root", "", "cim_system2");

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
        $error_message = "User not found or incorrect user type.";
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* General styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            background-image: url('./images/background.webp');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            color: #333;
        }

        .main-content {
            display: flex;
            flex-grow: 1;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 50px;
            box-sizing: border-box;
        }

        .login-container {
            display: flex;
            background-color: rgba(255, 255, 255, 0.95); /* Semi-transparent white background */
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            max-width: 1000px;
            width: 100%;
        }

        .login-box {
            width: 60%;
            padding-right: 20px;
            margin-left: 10px;
            margin-right: 12px;
        }

        .image-container {
            width: 40%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .image-fix {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }

        .image-container h1 {
            margin-bottom: 20px;
            font-size: 28px;
            text-align: center;
            color: #0C7EC2;
        }

        .image-container img {
            width: 70%;
            padding-bottom: 10px;
        }

        .login-box h2 {
            margin-bottom: 15px;
            color: #333;
            font-size: 24px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            margin-top: -5px;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="password"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
            outline: none;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 6px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: 8px;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        footer {
            background: linear-gradient(to bottom, #0C7EC2, #085B8E);
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .login-box,
            .image-container {
                width: 100%;
            }

            .image-container {
                margin-top: 20px;
            }
        }

        @media (max-width: 576px) {
            .header h1 {
                font-size: 18px;
            }

            .header img {
                height: 40px;
            }

            .login-box h2 {
                font-size: 18px;
            }

            .form-group label {
                font-size: 14px;
            }

            .form-group input[type="text"],
            .form-group input[type="password"],
            .btn {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="main-content">
        <div class="login-container">
            <div class="image-fix">
                <div class="image-container">
                    <h1>CHEMICAL INVENTORY MANAGEMENT SYSTEM</h1>
                    <img src="./images/loginimg.png" alt="Image">
                </div>
            </div>
            <div class="login-box">
                <h2>Login</h2>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <input type="submit" class="btn" name="login" value="Login">
                </form>
            </div>
        </div>
    </div>
    <footer>
        <p>Designed and maintained by <br>QRS&IT group</p>
    </footer>

    <?php if ($error_message): ?>
    <script>
        alert("<?php echo $error_message; ?>");
    </script>
    <?php endif; ?>

</body>
</html>
