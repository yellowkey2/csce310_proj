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




    ?>
</body>


</html>