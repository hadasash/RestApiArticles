<?php
$loggedin;
class User
{

    private $userName;
    private $password;

    public function __construct($userName, $password)
    {
        if (empty($userName)) {
            throw new Exception("Username cannot be empty");
        }

        if (empty($password)) {
            throw new Exception("Password cannot be empty");
        }

        $this->userName = $userName;
        $this->password = $password;
    }

    public function register()
{
    // Connect to the database
    $connection = mysqli_connect("localhost", "root", "", "usersDb");

    // Check if the user already exists
    $sql = "SELECT userName FROM users WHERE userName = '$this->userName'";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) > 0) {
        throw new Exception("User already exists");
    }

    // Hash the password using sha256
    $hashed_password = hash("sha256", $this->password);

    // Insert the user information into the users table
    $sql = "INSERT INTO users (userName, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $this->userName, $hashed_password);
    mysqli_stmt_execute($stmt);

    // Close the statement and the connection
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
}


    public function login() {
        $conn = mysqli_connect("localhost", "root", "", "usersDb");
        $sql = "SELECT password FROM users WHERE userName='$this->userName'";
        $result = mysqli_query($conn, $sql);
    
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (hash("sha256", $this->password) == $row["password"]) {
                $GLOBALS['loggedin'] = $this->userName;
                return true;

            } else {
                return false;
            }
        } else {
            return false;
        }
    
        mysqli_close($conn);
    }
    

    
}
