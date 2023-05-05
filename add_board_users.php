<!-- Created by Logan Talton -->
<!-- Edited by Sloan Davis -->
<?php
if (!$cur_board_id) {
    $cur_board_id = $_SESSION['curBoardId'];
}
?>

<div id="boardUsers">
    <h2>Add User to Board</h2>
    <form method="post" class="vertForm">
        <label for="usr_id">User ID:</label>
        <input type="text" id="usr_id" name="usr_id">
        <input type="submit" value="Add User">
        <span> is Editor? </span>
        <input type="checkbox" name="isEditor" value="Check to add editor permissions">
        <br>
    </form>
    <?php
    //add or update user to board
    if (isset($_POST["usr_id"])) {
        $usr_id = $_POST["usr_id"];
        $access_level = 2;
        if (isset($_POST["isEditor"])) {
            $access_level = 1;
        }
        //make sure we arent adding ourselves
        if ($_SESSION['usr_id'] == $usr_id) {
            echo "cannot add self";
        } else {
            //check if user already in board
            $sql = "SELECT usr_id FROM board_assign_usr WHERE usr_id = $usr_id AND board_id = " . $cur_board_id;
            $result = $conn->query($sql);
            //update user if already exists in board
            if ($result->fetch_row() != null) {
                $sql = "UPDATE board_assignments SET access_level = $access_level WHERE usr_id = $usr_id";
                $conn->query($sql);
                echo "updated user";

            } else {
                //add user if none of the above
                $sql = "INSERT INTO board_assignments (usr_id, board_id, access_level) VALUES ($usr_id, $cur_board_id, $access_level)";
                if ($conn->query($sql) === TRUE) {
                    echo "User added successfully";
                } else {
                    echo "Error: could not find user";
                }
            }
        }
    }
    ?>
    <h2>Remove User from Board</h2>
    <form method="post" class="vertForm">
        <label for="remove_usr_id">User ID:</label>
        <input type="text" id="remove_usr_id" name="remove_usr_id">
        <input type="submit" value="Remove User">
    </form>
    <?php
    if (isset($_POST["remove_usr_id"]) && $_POST["remove_usr_id"] != $_SESSION["usr_id"]) {
        $remove_usr_id = $_POST["remove_usr_id"];
        $sql = "DELETE FROM board_assignments WHERE board_id=$cur_board_id AND usr_id=$remove_usr_id";
        if ($conn->query($sql) === TRUE) {
            echo "User removed successfully";
        } else {
            echo "Error: could not find user";
        }
    }
    ?>

    <h2>Current Board Users</h2>
    <ul>
        <?php
        $sql = "SELECT DISTINCT usr_id FROM board_assignments WHERE board_id = $cur_board_id";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $usr_id = $row["usr_id"];
            $sql2 = "SELECT usr_name FROM users WHERE usr_id = $usr_id";
            $result2 = $conn->query($sql2);
            $row2 = $result2->fetch_assoc();
            $usr_name = $row2["usr_name"];
            echo "<li>$usr_id: $usr_name</li>";
        }
        ?>
    </ul>
</div>