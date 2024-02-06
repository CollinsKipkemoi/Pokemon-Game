<?php
$userN = $_GET["user"] ?? "";
$users = json_decode(file_get_contents("./userData.json"), true);
$user = null;
$userId = null;
foreach ($users as $key => $value) {
    if ($value["username"] === $userN) {
        $user = $value;
        $userId = $key;
        break;
    }
}
if ($user === null) {
    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="user.css">
    <style>
        h2 {
            text-align: center;
            color: rgb(81, 125, 129);
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
    <link rel="icon" href="./logo.png">
</head>

<body>
    <div class="title">
        <div class="first">
            <h1><a href="index.php">IKémon> user details</a></h1>
        </div>
        <div class="second">
            <p><a href="index.php">Home</a></p>
        </div>
    </div>
    <br>
    <h2>User Details</h2>
    <div class="user">
        <div class="userImage">
            <img src="./profile.jpeg" alt="profile image" width='100%' height="100%">
        </div>
        <div class="userInfo">
            <p>Username: <?php echo $user["username"] ?></p>
            <p>Email: <?php echo $user["email"] ?></p>
            <?php
            if ($user["username"] !== "admin") {
                echo "<p>Money: " .  $user['amount'] . " </p>";
            }

            ?>
        </div>
    </div>
    <h2>User Cards </h2>
    <div class='userCards'>
        <?php
        if (isset($user["cards"])) {
            foreach ($user["cards"] as $key => $value) {

                $imageClass = "image " . $value["type"];
                $id = $value["id"] . ' ' . $userId;
                echo "<div class='card'>";
                if ($user["username"] !== "admin") {

                    echo "<button class='sell'><a href='sell.php?id=" . $id . "'>Sell </a></button>";
                }
                echo "<div id='cardImage' class=' " . $imageClass . "'>";
                echo "<img src='" . $value["image"] . "' alt='card image' width='100%' height='100%'>";
                echo "</div>";
                echo "<p>Name: " . $value["name"] . "</p>";
                echo "<p>🏷️: " . $value["type"] . "</p>";
                echo "<div class='cardInfo'>";
                echo "<div class='info'>";
                echo "<p>❤️: " . $value["hp"] . "</p>";
                echo "<p>🛡️: " . $value["defense"] . "</p>";
                echo "<p>⚔️: " . $value["attack"] . "</p>";
                echo "</div>";
                echo "<p class='price'>💰: " . $value["price"] . "</p>";
                echo "</div>";
                echo "</div>";
            }
        }
        ?>
    </div>

</body>

</html>