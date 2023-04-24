<?php session_start(); ?>
<html>
 
<?php include('templates/head.php'); ?>

<body>
    <?php include('templates/header.php'); ?>
    <?php include('templates/menu.php'); ?>
    <?php include('templates/db_login.php'); ?>

    <!-- Store username from login -->
    <?php
    //if usr_name not set, return to index
    if(!isset($_SESSION['usr_name'])){
        header('Location: index.php');
        exit;
    }

    // Retrieve user id associated with username
    $sql = "SELECT usr_id FROM csce310_db.users WHERE usr_name = '" . $_SESSION['usr_name'] . "'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $usr_id = $row['usr_id'];
    $board_admin_id = $usr_id;
    
    ?>

    <!-- Display welcome messsage for usr_name -->
    <p>Welcome <?php echo $_SESSION['usr_name']; ?>!</p>
    <p> Your user id is <?php echo $usr_id; ?> </p>

    <!-- Create board -->
    <p>Create a board</p>
    <form action="create_board.php" method="post">
        <input type="text" name="board_name" placeholder="Board name">
        <input type="hidden" name="usr_id" value="<?php echo $usr_id; ?>">
        <input type="submit" value="Create board">
    </form>

    <!-- Display boards that user is in-->
    <p>Boards that you are in</p>
    <?php
    $sql = "SELECT * FROM csce310_db.board_assignments WHERE usr_id = (SELECT usr_id FROM csce310_db.users WHERE usr_name = '" . $username . "')";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        #print each row (usr_id	usr_name	usr_passwd	board_id	profile_desc)
        echo "<button> Board name: " . $row["board_name"] . "</button>";
        echo "<br> Board id: " . $row["board_id"] .  "<br> Board admin id: " . $row["board_admin_id"] . " <br>" . "<br>";
    }
    ?>

    <!-- Display boards that user is admin of -->
    <p>Boards you are admin of</p>
    <?php
    $sql = "SELECT * FROM csce310_db.board WHERE board_admin_id = $usr_id";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        #print each row (board_id board_name board_admin_id)
        echo "Board name: " . $row["board_name"] . "<br> Board id: " . $row["board_id"] .  "<br> Board admin id: " . $row["board_admin_id"] . " <br>" . "<br>";
        
    }
    $conn->close();
    ?>
    
    <!-- Delete a board user is admin of -->
    <p>Delete a board</p>
    <form action="delete_board.php" method="post">
        <input type="text" name="board_name" placeholder="Board name">
        <input type="hidden" name="usr_id" value="<?php echo $usr_id; ?>">
        <input type="submit" value="Delete board">
    
</body>

</html>

