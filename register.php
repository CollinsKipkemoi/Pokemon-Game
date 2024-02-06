<?php
include_once("storage.php");
$userData = new Storage(new JsonIO("./userData.json"));
$users = $userData->findAll();
$userName = $_POST["username"] ?? "";
$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";
$confirmPassword = $_POST["confirmPassword"] ?? "";
$errors = [];
if ($_POST) {
    // Username validation
    if ($userName === "") {
        $errors["userName"] = "Username is required";
    } else if (strlen($userName) < 2) {
        $errors["userName"] = "Username must be at least 2 characters";
    } else {
        foreach ($users as $user) {
            if ($user["username"] === $userName) {
                $errors["userName"] = "Username already exists";
                break;
            } 
        }
    }

    // Email validation
    if ($email === "") {
        $errors["email"] = "Email is required";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Email is not valid";
    }
    foreach ($users as $user) {
        if ($user["email"] === $email) {
            $errors["email"] = "Email already exists";
            break;
        }
    }
    // Password validation
    if ($password === "") {
        $errors["password"] = "Password is required";
    } else if (strlen($password) < 6) {
        $errors["password"] = "Password must be at least 6 characters";
    }
    // Confirm password validation
    if ($confirmPassword === "") {
        $errors["passwordConfirm"] = "Confirm Password is required";
    } else if ($password !== $confirmPassword) {
        $errors["passwordConfirm"] = "Passwords do not match";
    }
}
if (count($errors) === 0 && $_POST) {
    $user = [
        "username" => $userName,
        "email" => $email,
        "password" => $password,
        "amount" => 1000,
        "cards" => []
    ];
    $userData->add($user);
    session_start();
    // set session variables
    $_SESSION["userName"] = $userName;
    $_SESSION["password"] = $password;
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo.png">
    <script src="https://kit.fontawesome.com/0c0bb61621.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="user.css">
    <title>Register</title>
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
    <div class="form">
        <div class="intro">
            <div class="image">
                <img src="logo.png" alt="logo">
            </div>
            <h3>REGISTER</h3>
        </div>
        <form action="register.php" method="POST" novalidate>
            <div class="emailDiv">
                <label for="email">Email Address</label>
                <br>
                <div class="emailInput">
                    <input type="text" name="email" id="email" placeholder="Enter your email" value=<?=$email ?? ''?>>
                    <i class="fa-solid fa-envelope"></i>
                    <br>
                    <?= "<p class='error'>" . ($errors["email"] ?? "") . "</p>" ?>
                </div>
                <div class="usernameDiv">
                    <label for="username">Username</label>
                    <br>
                    <div class="usernameInput">
                        <input type="text" name="username" id="username" placeholder="Enter your username" value = <?=$userName ?? ''?>>
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <?= "<p class='error'>" . ($errors["userName"] ?? "") . "</p>" ?>
                    <br>
                </div>
                <div class="passwordDiv">
                    <label for="password">Password</label>
                    <br>
                    <div class="passwordInput">
                        <input type="password" name="password" id="password" placeholder="Enter your password" value=<?=$password ?? ''?>>
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <?= "<p class='error'>" . ($errors["password"] ?? "") . "</p>" ?>
                    <br>
                </div>
                <div class="confirmPassDiv">
                    <label for="confirmPassword">Confirm Password</label>
                    <br>
                    <div class="passwordInput">
                        <input type="password" name="confirmPassword" id="confirmPassword" placeholder="confirm password" value=<?=$confirmPassword ?? ''?>>
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <?= "<p class='error'>" . ($errors["passwordConfirm"] ?? "") . "</p>" ?>
                    <br>
                </div>
                <div class="submitDiv">
                    <input type="submit" value="Register">
                </div>
        </form>
        <p class="already">I am already a member! <a href="sign-in.php">Sign in</a></p>
    </div>
</body>

</html>