<?php session_start(); ?>
<html>

<head>
    <title>CSCE 310 Project</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php
    //include templates
    include('templates/db_login.php');
    include('templates/menu.php');
    include('templates/header.php');
    ?>

    <h1>Project Management System</h1>
    <p>Create Account</p>
    <form action="create_account.php" method="post">
    Username: <input type="text" name="usr_name"><br>
    Password: <input type="text" name="usr_password"><br>
    <input type="submit">
    </form>

    <p>Login</p>
    <form action="login.php" method="get">
    Username: <input type="text" name="usr_name"><br>
    Password: <input type="text" name="usr_password"><br>
    <input type="submit">
    </form>

    <?php include('templates/footer.php'); ?>
</body>

</html>