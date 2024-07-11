<?php
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Database connection
    $conn = new mysqli("localhost", "root", "", "csd_system");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL query with JOIN to fetch fullname and user_type from id_emp table
    $query = "SELECT e.id, e.password, e.desig_id, e.group_id, e.first_name, e.middle_name, e.last_name, e.is_created, d.desig_fullname, g.fullname AS group_fullname, e.user_type
              FROM id_emp e
              INNER JOIN id_desig d ON e.desig_id = d.id
              INNER JOIN id_group g ON e.group_id = g.group_id
              WHERE e.username = '$username'";
    
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
            $_SESSION['user_type'] = $row['user_type'];

            // Determine redirection based on user_type
            if ($row['user_type'] === 'user') {
                header('Location: user_dashboard.php');
                exit;
            } elseif ($row['user_type'] === 'admin') {
                header('Location: admin_dashboard.php');
                exit;
            } else {
                $_SESSION['error_message'] = "Invalid user type.";
            }
        } else {
            $_SESSION['error_message'] = "Incorrect password.";
        }
    } else {
        $_SESSION['error_message'] = "User not found.";
    }

    $conn->close();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Clear error message after displaying it
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
} else {
    $error_message = '';
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<style>
body {
  font-family: sans-serif;
  margin: 0;
  padding: 0;
  
  background-color:#f5ffe3;   #f5ebff
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}
main {
  flex: 1; /* Ensure main content takes up remaining space */
}
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 70%;
  margin: 200px auto;
  background-color: mintcream;
  /* margin-bottom:50px; */
  padding: 20px;
  border-radius: 15px; /* Rounded corners for the container */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  flex: 1;
}

.left {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}

.right {
  flex: 1;
}

h1 {
  text-align: center;
  margin-bottom: 20px;
  font-size: 40px;
  margin-bottom: 40px;
}

input[type="text"],
input[type="password"] {
  width: 100%;
  padding: 10px;
  font-size: 15px;
  margin: 10px 0;
  border: 1px solid #ddd;
  border-radius: 5px; /* Rounded corners for the input fields */
  margin-bottom: 20px;
  box-sizing: border-box;
}
button {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  margin: 10px auto; /* Center the button horizontally */
  border: none;
  border-radius: 5px; /* Rounded corners for the button */
  cursor: pointer;
  width: auto; /* Adjust width to fit content */
  max-width: 200px; /* Set maximum width if needed */
  text-align: center; /* Center align text */
  font-size: 16px;
  display: block; /* Ensure block display for centering */
}

button:hover {
  background-color: #45a049;
}



.forgot {
  text-align: center;
  margin-top: 10px;
}

.forgot a {
  color: #4CAF50;
  text-decoration: none;
}

.forgot a:hover {
  text-decoration: underline;
}

footer {
  background-color: #002147;
  color: white;
  text-align: center;
  padding: 10px 0;
  margin-top: auto;
}

img {
  max-width: 90%; /* Reduce image size to 90% */
  height: auto;
}

.error {
  color: red;
  text-align: center;
  margin-bottom: 10px;
}

.bold-label {
  font-weight: bold;
  font-size:20px;
}
</style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
  <div class="left">
    <img src="./images/loginlogo.png" alt="Login Image">
  </div>
  <div class="right">
    <h1>Login Credentials</h1>
    <?php if (!empty($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
    <form method="post">
      <label for="username" class="bold-label">Username:</label>
      <input type="text" id="username" name="username" placeholder="Type your username" required>
      <label for="password" class="bold-label">Password:</label>
      <input type="password" id="password" name="password" placeholder="Type your password" required>
      <button type="submit" name="login">Submit</button>
    </form>
  </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
