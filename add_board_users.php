<div id="boardUsers">
        <h2>Add User to Board</h2>
        <form method="post">
            <label for="usr_id">User ID:</label>
            <input type="text" id="usr_id" name="usr_id">
            <input type="submit" value="Add User">
            <span> is Editor? </span>
            <input type="checkbox" name="isEditor" value="Check to add editor permissions">
            <br>
        </form>
        <?php
        if (isset($_POST["usr_id"])) {
            $usr_id = $_POST["usr_id"];
            $access_level = 2;
            if(isset($_POST["isEditor"])){
                $access_level = 1;
            }
            $sql = "INSERT INTO board_assignments (usr_id, board_id, access_level) VALUES ($usr_id, $cur_board_id, $access_level)";
            if ($conn->query($sql) === TRUE) {
                echo "User added successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        ?>
        <h2>Remove User from Board</h2>
        <form method="post">
            <label for="remove_usr_id">User ID:</label>
            <input type="text" id="remove_usr_id" name="remove_usr_id">
            <input type="submit" value="Remove User">
        </form>
        <?php
        if (isset($_POST["remove_usr_id"])) {
            $remove_usr_id = $_POST["remove_usr_id"];
            $sql = "DELETE FROM board_assignments WHERE board_id=$cur_board_id AND usr_id=$remove_usr_id";
            if ($conn->query($sql) === TRUE) {
                echo "User removed successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
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