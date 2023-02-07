<?php

include_once("models/User.php");

if (isset($_POST["userName"]) && !empty($_POST["userName"]) &&
    isset($_POST["password"]) && !empty($_POST["password"])) {
    $userName = $_POST["userName"];
    $password = $_POST["password"];

    $user = new User($userName, $password);
    try {
        $user->register();
        // Redirect to the login page
        header("Location: login.php");
    } catch (Exception $e) {
        // User already exists
        echo "User already exists";
    }
} else {
    echo "Sign Up";

}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Register page</title>

</head>
<body>
    <form action="register.php" method="post">
       <br/> <input type="text" name="userName" placeholder="userName"><br/>
        <input type="password" name="password" placeholder="Password">
        <input type="submit" name="submit" value="Sign up">
    </form>
</body>
</html>
