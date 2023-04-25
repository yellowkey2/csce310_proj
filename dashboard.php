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
    if (!isset($_SESSION['usr_name'])) {
        header('Location: index.php');
        exit;
    }

    // Retrieve user id associated with username
    $sql = "SELECT usr_id FROM users WHERE usr_name = '" . $_SESSION['usr_name'] . "'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $usr_id = $row['usr_id'];
    $_SESSION['usr_id'] = $usr_id;

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
    <p><b>Boards that you are in:</b></p>
    <?php
    $sql = "SELECT * FROM board_assignments WHERE usr_id = '" . $usr_id . "'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "<form method='post' action='board.php?boardID=" . $row["board_id"] . "'>";
        echo $row["board_id"] . ": " . "<input type='submit' name='loadBoardButton' value='Go To Board'>";
        echo "</form>";
        //allows board.php to know if user has access to the board
        $_SESSION['board_id_' . $row["board_id"]] = true;
    }
    ?>
    <hr>

    <!-- Display boards that user is admin of -->
    <p><b>Boards you are admin of:</b></p>
    <?php
    $sql = "SELECT * FROM board WHERE board_admin_id = $usr_id";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        #print each row (board_id board_name board_admin_id)
        echo "Board name: " . $row["board_name"] . "<br> Board id: " . $row["board_id"] .  "<br> Board admin id: " . $row["board_admin_id"] . " <br>" . "<br>";
    }
    $conn->close();
    ?>
    <hr>
    <!-- Delete a board user is admin of -->
    <p>Delete a board</p>
    <form action="delete_board.php" method="post">
        <input type="text" name="board_name" placeholder="Board name">
        <input type="hidden" name="usr_id" value="<?php echo $usr_id; ?>">
        <input type="submit" value="Delete board">

</body>

</html>