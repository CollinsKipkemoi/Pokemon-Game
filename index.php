<?php
session_start();
$current_user = $_SESSION["userName"] ?? "";
$userID = $_SESSION["userID"] ?? "";
include_once("storage.php");
$cards = new Storage(new JsonIO("./pokemon.json"));
$data = $cards->findAll();
// shuffle($data);
$allUsers = new Storage(new JsonIO("./userData.json"));
$users = $allUsers->findAll();
$money = null;
foreach ($users as $user) {
    if ($user["username"] === $current_user) {
        if (isset($user["amount"])) {
            $money = $user["amount"];
        } 
    }
}
$filter = $_GET["type"] ?? "";
if ($filter !== "") {
    $data = array_filter($data, function ($card) use ($filter) {
        return $card["type"] === $filter;
    });
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo.png">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/0c0bb61621.js" crossorigin="anonymous"></script>
    <title>Ikemon</title>
</head>

<body>
    <div class="title">
        <div class="first">
            <h1><a href="index.php">IKémon > Home</a></h1>
        </div>
        <div class="sign">

            <?php

            if ($current_user === "") {
                echo '<button><a href="sign-in.php">Sign in</a></button>';
                echo '<button><a href="register.php">Register</a></button>';
            } else if ($current_user !== "admin") {
                echo '<a href="buy.php">Buy</a>';
            } else if ($current_user === "admin") {
                echo '<button><a href="create.php">Create <i class="fa-solid fa-plus"></i></a></button>';
            }
            if ($current_user !== "") {
                // username
                echo "<div class = 'userName'>";
                echo "<a href='./userDetails.php?user=" . $current_user . "'>";
                echo "<div class='pImage'> </div>";
                echo '<p>' . $current_user . '</p>';
                echo "</a>";
                echo "</div>";
                if($current_user !== "admin"){
                    echo "<p class='money'>Balance<i class='fa-solid fa-sack-dollar'></i>: " . $money . "</p>";
                }
                echo '<a href="logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i></a>';
            }
            ?>
        </div>
    </div>
    <div class="filter">
        <form method="GET" action="index.php" novalidate>
            <select name="type">
                <option value="">All</option>
                <option value="fire">Fire</option>
                <option value="water">Water</option>
                <option value="electric">Electric</option>
                <option value="grass">Grass</option>
                <option value="normal">Normal</option>
                <option value="bug">Bug</option>
                <option value="poison">Poison</option>
            </select>
            <input type="submit" value="Filter">
        </form>
    </div>
    <div class="cards">
        <?php
        foreach ($data as $id => $card) {
            $imageClass = "image " . $card["type"];
            echo '<div class="card">';
            echo '<div class="' . $imageClass . '">';
            echo '<a href = "cardDetails.php?id=' . $id . '"> <img src="' . $card["image"] . '" alt="' . $card["name"] . '"></a>';
            echo '</div>';
            echo '<p class="name">' . $card["name"] . '</p>';
            echo '<p>🏷️ ' . $card["type"] . '</p>';
            echo '<div class="details">';
            echo '<div class="stats">';
            echo '<p><i class="fa-solid fa-heart"></i> ' . $card["hp"] . '</p>';
            echo '<p>⚔️ ' . $card["attack"] . '</p>';
            echo '<p>🛡️' . $card["defense"] . '</p>';
            echo '</div>';
            echo '<p class="price"><i class="fa-solid fa-sack-dollar"></i>  ' . $card["price"] . '</p>';
            echo '</div>';
            $owner = $card["owner"] ?? "";
            $cardAndUser = $id . " " . $current_user;
            if ($owner !== "" && $owner === "admin" && $current_user !== "admin" && $current_user !== "") {
                echo '<button class="buy"><a href="./buy.php?info=' . $cardAndUser . '">Buy</a></button>';
            }
            echo '</div>';
        }
        ?>
    </div>
    <footer>
        <p>IKémon | Collins @2023</p>
        <a href="" target="_blank"></a>
    </footer>
</body>

</html>