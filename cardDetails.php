<?php
include_once("storage.php");
$stor = new Storage(new JsonIO('pokemon.json'));
$id = $_GET['id'] ?? -1;
$data = $stor->findById($id);
$navClass = $data["type"];
if ($data === null) {
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo.png">
    <link rel="stylesheet" href="details.css">
    <title>Card Details</title>
</head>

<body>
    <div class=<?= $navClass ?> id="title">


        <div class="first">
            <h1>IKémon > Card Details</h1>
        </div>
        <div class="right">
            <ul>
                <li><a href="index.php">Home</a></li>
            </ul>
        </div>
    </div>
    <div class="details">
        <?php

        $imageClass = "image " . $data["type"];
        echo "<div class=' " . $imageClass . " '>";
        echo "<img src='" . $data["image"] . "' alt='" . $data["name"] . "'>";
        echo "</div>";
        echo "<h3> " . $data["name"] . "</h3>";
        echo "<div class='info'>";
        echo "<p>" . "🏷️: " . $data["type"] . "</p>";
        // hp
        echo "<p>❤️: " . $data["hp"] . "</p>";
        echo "<p>" . "Description: " . $data["description"] . "</p>";
        echo "</div>";
        ?>
    </div>
</body>

</html>