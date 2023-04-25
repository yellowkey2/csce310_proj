<?php
session_start();
include("templates/db_login.php");
?>
<html>
<?php include("templates/head.php"); ?>

<body>
    <?php
    include('templates/header.php');
    
    //make sure we have a board id
    $cur_board_id = "";
    if(!isset($_GET["boardID"])){
        echo "no board found...";
        exit;
    }
    $cur_board_id = $_GET["boardID"];
    
    //make sure user has authorization to view this board 
    $sql = "SELECT * FROM board_assignments WHERE usr_id = " . $_SESSION['usr_id'] . " AND board_id = " . $cur_board_id;
    $result = $conn->query($sql);
    if($result->num_rows == 0){
        echo "Incorrect Board Access";
        exit;
    }
    
    


    ?>
</body>


</html>