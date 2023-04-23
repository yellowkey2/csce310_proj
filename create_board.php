
<!DOCTYPE html>
<html>
 
<head>
    <title>Create Board</title>
</head>
 
<body>
    <center>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "csce310_db");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else
            echo "Connected successfully <br>";
        $board_admin_id = $_REQUEST['usr_id'];
        $board_name = $_REQUEST['board_name'];

        $sql = "INSERT INTO board (board_name, board_admin_id) VALUES ('" . $board_name . "', '" . $board_admin_id . "')";
        $result = $conn->query($sql);

        // Check if board was created
        $sql = "SELECT * FROM board WHERE board_name = '" . $board_name . "' AND board_admin_id = '" . $board_admin_id . "'";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            echo "Board was not created";
        } else {
            echo "Board created successfully";
            // Redirect to dashboard page
            header("Location: dashboard.php");
        }
        mysqli_close($conn);
        ?>
    </center>
</body>

</html>