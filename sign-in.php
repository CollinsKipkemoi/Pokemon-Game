<?php
include_once("storage.php");
$userData = new Storage(new JsonIO("./userData.json"));
$users = $userData->findAll();
$userName = $_POST["username"] ?? "";
$password = $_POST["password"] ?? "";
$errors = [];
if ($_POST) {
    // Username validation
    if ($userName === "") {
        $errors["userName"] = "Username is required";
    }
    if (strlen($userName) < 2) {
        $errors["userName"] = "Username must be at least 2 characters";
    }
    foreach ($users as $user) {
        if ($user["username"] === $userName) {
            if ($user["password"] === $password) {
                // start session
                session_start();
                $_SESSION["userName"] = $userName;
                $_SESSION["password"] = $password;
                header("location: index.php");
                exit;
            } else {
                $errors["password"] = "Password is incorrect";
                break;
            }
        }
    }
    // if username does not exist
    if (!isset($errors["password"]) && !isset($errors["userName"])) {
        $errors["userName"] = "Username does not exist";
    }
    // Password validation
    if ($password === "") {
        $errors["password"] = "Password is required";
    } 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user.css">
    <script src="https://kit.fontawesome.com/0c0bb61621.js" crossorigin="anonymous"></script>
    <title>Sign-in</title>
</head>

<body>
    <div class="title">
        <div class="first">
            <h1><a href="index.php">IKémon</a></h1>
        </div>
        <div class="second">
            <p><a href="index.php">Home</a></p>
        </div>
    </div>
    <!-- sign in form -->
    <div class="form">
        <div class="intro">
            <div class="image">
                <img src="logo.png" alt="logo">
            </div>
            <h3>LOGIN</h3>
        </div>
        <form action="sign-in.php" method="POST" novalidate>
            <div class="usernameDiv">
                <label for="email">Username</label>
                <div class="usernameInput">
                    <input type="text" name="username" id="username" placeholder="Enter your username" value=<?= $userName ?? '' ?>>
                    <i class="fa-solid fa-user"></i>
                </div>
                <p class="error"><?php echo $errors["userName"] ?? "" ?></p>
            </div>
            <div class="passwordDiv">
                <label for="password">Password</label>
                <div class="passwordInput">
                    <input type="password" name="password" id="password" placeholder="Enter your password" value=<?= $password ?? '' ?>>
                    <i class="fa-solid fa-lock"></i>
                </div>
                <p class="error"><?php echo $errors["password"] ?? "" ?></p>
            </div>
            <div class="submitDiv">
                <input type="submit" value="Login">
            </div>
        </form>
        <p class="not-member">Not a member? <a href="register.php">Register</a></p>
    </div>
</body>

</html>