<?php

include_once("User.php");

if (isset($_POST["userName"]) && !empty($_POST["userName"]) &&
    isset($_POST["password"]) && !empty($_POST["password"])) {
    $userName = $_POST["userName"];
    $password = $_POST["password"];

    $user = new User($userName, $password);
   // $user->register();
    if ($user->register()) {
        // Redirect to the login page
        header("Location: login.php");
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