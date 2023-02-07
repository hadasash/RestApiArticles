<?php

include_once("User.php");

if (isset($_POST["submit"])) {
    $userName = $_POST["userName"];
    $password = $_POST["password"];

    $user = new User($userName, $password);

    if ($user->login()) {
        // Redirect to the success page
        header("Location: success.php");
    } else {
        // Redirect to the register page
        header("Location: register.php");
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="post">
        <input type="text" name="userName" placeholder="userName"><br/>
        <input type="password" name="password" placeholder="Password">
        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>
