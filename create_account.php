
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

        $sql = "INSERT INTO users (usr_name, usr_passwd) VALUES ('" . $username . "', '" . $password . "')";

        if(mysqli_query($conn, $sql)){
            echo "Records added successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }

        mysqli_close($conn);
        ?>
    </center>
</body>

</html>