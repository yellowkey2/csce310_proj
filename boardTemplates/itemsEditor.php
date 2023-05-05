<!-- This is a component that will be rendered in the Dashboard to display board items with editing capability -->
<!-- THIS FILE IS BY SLOAN DAVIS -->
<?php
// print_r($_SESSION);
include("templates/db_login.php");
$board_id = "";
//check if got a boardid
if (!$_GET["boardID"]) {
    exit;
}
$board_id = $_GET['boardID'];
//check if has permission
if ($_SESSION['b_id_' . $board_id] == false) {
    echo "no board permission";
    exit;
}

//handle query for add item
if (isset($_POST['addItemBtn']) && isset($_POST['itemContent'])) {
    $usr_id = $_SESSION['usr_id'];
    $timestamp = date('Y-m-d', time());
    $post_type = 0;
    $content = $_POST['itemContent'];

    $sql = "INSERT INTO board_item (item_timestamp, item_posttype, item_content, usr_id, board_id) 
    VALUES ('$timestamp', '$post_type', '$content', $usr_id, $board_id)";
    $conn->query($sql);
}

//handle queries for update and delete
$item_id = "";
if (isset($_POST['item'])) {
    $item_id = $_POST['item'];
}
//delete item
if (isset($_POST['delete'])) {
    $sql = "DELETE FROM board_item WHERE item_id = $item_id AND board_id = $board_id";
    $conn->query($sql);
}

//update item
if (isset($_POST['update'])) {
    $isChecked = 0;
    if (isset($_POST['isComplete'])) {
        $isChecked = 1;
    }
    $sql = "UPDATE board_item SET item_posttype= '$isChecked' WHERE item_id = $item_id AND board_id = $board_id";
    $conn->query($sql);
}
?>
<div class="vertScroll">
    <?php
    //get and display items
    $sql = "SELECT * FROM board_item WHERE board_id = '" . $board_id . "'";
    $items = $conn->query($sql);
    while ($row = $items->fetch_assoc()) {
        //skip if comment
        if ($row['item_posttype'] > 1) {
            continue;
        }
        $checked = "";
        if ($row['item_posttype'] == '1') {
            $checked = "checked";
        }
        echo "<form method='POST' class='boardItemEditor'>";
        echo "complete? ";
        echo "<input type='checkbox' name='isComplete' $checked>";
        echo "<input type='hidden' name='item' value='" . $row['item_id'] . "' >";
        echo $row['item_content'];
        echo "<button type='submit' name='delete'>Delete</button>";
        echo "<button type='submit' name='update'>Update</button>";
        echo "</form>";
    }
    ?>
</div>
<div id="addBoardItem">
    <h3>Add Item:</h3>
    <form method="POST">
        <input type="text" name="itemContent" placeholder='Item Text'>
        <button type="submit" name="addItemBtn">Submit</button>
    </form>
</div>