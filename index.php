<html>

<head>
    <title>CSCE 310 Project</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php include('templates/header.php'); ?>
    <?php include('templates/menu.php'); ?>

    <?php
    include('templates/db_login.php');

    // Create new line
    // Select users table information and display it on the website
    $sql = "SELECT * FROM csce310_db.users";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        #print each row (usr_id	usr_name	usr_passwd	board_id	profile_desc)
        echo "id: " . $row["usr_id"] . "<br> Name: " . $row["usr_name"] .  "<br> Password: " . $row["usr_passwd"] . " <br>" . "<br>";
    }
    $conn->close();
    // Check that connection is closed
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else
        echo "Connection closed successfully <br>";
    ?>

    <h1>CSCE 310 Final Project</h1>
    <p>My content</p>

    <?php include('templates/footer.php'); ?>
</body>

</html>