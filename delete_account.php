<?php 
session_start();
if(!isset($_SESSION['usr_id'])){
    echo "no account found to delete";
    exit;
}
//TODO

?>