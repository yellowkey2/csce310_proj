
<!DOCTYPE html>
<html>
 
<head>
    <title>Login</title>
</head>
 
<body>
    <center>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "csce310_db");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else
            echo "Connected successfully <br>";

        $username = $_REQUEST['usr_name'];
        $password = $_REQUEST['usr_password'];
        // Check if username is already in the database
        $sql = "SELECT * FROM users WHERE usr_name = '" . $username . "' AND usr_passwd = '" . $password . "'";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            echo "Username or password is incorrect";
            // Redirect to login page
            // header("Location: index.php");
        } else {
            echo "Login successful";
            // Redirect to dashboard page
            // header("Location: dashboard.php");
        }

        mysqli_close($conn);
        ?>
    </center>
</body>

</html>