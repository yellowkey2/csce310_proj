<!-- This is a component that will be rendered in the Dashboard to display board comments with editing capability -->


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

//handle query for add comment
if (isset($_POST['addCommentBtn']) && isset($_POST['commentContent'])) {
    $usr_id = $_SESSION['usr_id'];
    $timestamp = date('Y-m-d', time());
    $post_type = 2;
    $content = $_POST['commentContent'];

    $sql = "INSERT INTO board_item (item_timestamp, item_posttype, item_content, usr_id, board_id) 
    VALUES ('$timestamp', '$post_type', '$content', $usr_id, $board_id)";
    $conn->query($sql);
}



//handle queries for update and delete
$item_id = "";
if (isset($_POST['item'])) {
    $item_id = $_POST['item'];
}

//handle query for edit comment
if (isset($_POST['editCommentBtn']) && isset($_POST['editCommentContent'])) {
    $usr_id = $_SESSION['usr_id'];
    $timestamp = date('Y-m-d', time());
    $post_type = 2;
    $content = $_POST['editCommentContent'];
    $sql = "UPDATE board_item SET item_content = '$content' WHERE item_id = $item_id AND board_id = $board_id";
    $conn->query($sql);
}

//delete item
if (isset($_POST['delete'])) {
    $sql = "DELETE FROM board_item WHERE item_id = $item_id AND board_id = $board_id";
    $conn->query($sql);
}

//update item
if (isset($_POST['edit'])) {
    echo "<form method='POST'>";
            echo "<input type='text' name='editCommentContent' placeholder=' Edit Comment'>";
            echo "<input type='hidden' name='item' value='" . $_POST['item'] . "' >";
            echo "<button type='update' name='editCommentBtn'>Submit</button>";
        echo "</form>";
    // $isChecked = 0;
    // if (isset($_POST['isComplete'])) {
    //     $isChecked = 1;
    // }
    // $content = ;
    // $sql = "UPDATE board_item SET item_content = '$content' WHERE item_id = $item_id AND board_id = $board_id";
    // $conn->query($sql);
}
?>
<div class="vertScroll">
    <?php
    //get and display items
    $sql = "SELECT * FROM board_item WHERE (board_id = '" . $board_id . "' AND item_posttype = 2)";
    $items = $conn->query($sql);

    $usr_id = $_SESSION['usr_id'];
    
    // echo $commentUsr_id['usr_id'];
    
    while ($row = $items->fetch_assoc()) {
        $sql = "SELECT * FROM board_item WHERE item_id = " . $row['item_id'];
    
        $commentUsr_id2 = $conn->query($sql);
        $commentUsr_id = $commentUsr_id2->fetch_assoc();
        //skip if comment
        echo "<form method='POST' class='boardItemEditor'>";
        // echo "complete? ";
        // echo "<input type='checkbox' name='isComplete' $checked>";
        echo "<input type='hidden' name='item' value='" . $row['item_id'] . "' >";
        echo $row['item_content'];

        if ($usr_id == $commentUsr_id['usr_id']) {
            echo "<button type='submit' name='delete'>Delete</button>";
            echo "<button type='submit' name='edit'>Edit</button>";
        }

        echo "</form>";
    }
    ?>
    
</div>

<!-- Neccessary for spacing. DO NOT REMOVE -->
<p id="addBoardItem"></p>
<div id="addBoardItem">
    <h3>Add Comment:</h3>
    <form method="POST">
        <input type="text" name="commentContent" placeholder='Comment Text'>
        <button type="submit" name="addCommentBtn">Submit</button>
    </form>
</div>
